# Resumist Backend Route Requirements (From Frontend Pages)

This version is focused on what backend routes are required because the frontend pages exist.

## Scope

- Frontend scanned: auth, candidate dashboard, recruiter dashboard, payment, admin approvals, contact
- Base API: /api/v1
- API style: REST

## 1) Must-Have Auth Routes

These are required from your auth pages.

### 1.1 Login

- Route: POST /api/v1/auth/login
- Type: JSON
- Used by: /(auth)/login
- Example payload:

```json
{
  "email": "user@example.com",
  "password": "password123",
  "rememberMe": true
}
```

### 1.2 Register

- Route: POST /api/v1/auth/register
- Type: JSON
- Used by: /(auth)/signup
- Example payload:

```json
{
  "fullName": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "acceptTerms": true
}
```

### 1.3 Forgot Password

- Route: POST /api/v1/auth/forgot-password
- Type: JSON
- Used by: /(auth)/login
- Example payload:

```json
{
  "email": "john@example.com"
}
```

### 1.4 Reset Password

- Route: POST /api/v1/auth/reset-password
- Type: JSON
- Used by: reset flow link from email
- Example payload:

```json
{
  "token": "reset-token",
  "newPassword": "newPassword123"
}
```

### 1.5 Session/Me + Logout

- Route: GET /api/v1/auth/me
- Route: POST /api/v1/auth/logout
- Type: JSON
- Used by: guarded layouts and header profile state

## 2) Candidate Dashboard Route Requirements

These come from pages under /dashboard.

### 2.1 Dashboard Home Summary

- Route: GET /api/v1/candidate/dashboard
- Type: JSON
- Used by: /dashboard
- Example response shape:

```json
{
  "resumeCount": 6,
  "latestScore": 91,
  "creditsLeft": 1,
  "recentOptimizations": []
}
```

### 2.2 Resume Library (versions)

- Route: GET /api/v1/candidate/resumes
- Route: POST /api/v1/candidate/resumes
- Route: GET /api/v1/candidate/resumes/{resumeId}
- Route: PATCH /api/v1/candidate/resumes/{resumeId}
- Route: DELETE /api/v1/candidate/resumes/{resumeId}
- Route: POST /api/v1/candidate/resumes/{resumeId}/archive
- Route: POST /api/v1/candidate/resumes/{resumeId}/restore
- Type: GET/PATCH JSON, POST multipart
- Used by: /dashboard/versions, /dashboard/upload
- Query params for list:
  - `status`: `draft`, `active`, or `archived`
- The list response is optimized for the resume-library cards:

```json
{
  "data": [
    {
      "id": 12,
      "name": "Software_Engineer_v3.pdf",
      "context": "Google SWE",
      "date": "2025-01-15",
      "date_label": "Jan 15, 2025",
      "status": "active",
      "badge": {
        "label": "Active",
        "tone": "success"
      },
      "score": 92,
      "score_label": "92%",
      "score_tone": "success",
      "latest_optimization_id": 44,
      "report_available": true,
      "download_available": true,
      "created_at": "2025-01-15T00:00:00+00:00"
    }
  ]
}
```
- Example upload payload:

```json
{
  "file": "<binary-pdf-or-docx>",
  "name": "Software_Engineer_v3.pdf"
}
```

### 2.3 Resume Editor

- Route: GET /api/v1/candidate/resumes/{resumeId}/content
- Route: PUT /api/v1/candidate/resumes/{resumeId}/content
- Route: POST /api/v1/candidate/resumes/{resumeId}/export
- Type: JSON
- Used by: /dashboard/editor
- Example save payload:

```json
{
  "blocks": [
    {
      "section": "summary",
      "text": "Experienced Software Engineer..."
    }
  ],
  "format": "rich_text"
}
```

### 2.4 Optimize Flow (main candidate feature)

- Route: POST /api/v1/candidate/optimization-flows
- Route: POST /api/v1/candidate/optimizations
- Route: GET /api/v1/candidate/optimizations
- Route: GET /api/v1/candidate/optimizations/{optimizationId}
- Route: GET /api/v1/candidate/optimizations/{optimizationId}/status
- Route: GET /api/v1/candidate/optimizations/{optimizationId}/report
- Route: GET /api/v1/candidate/optimizations/{optimizationId}/heatmap
- Route: POST /api/v1/candidate/optimizations/{optimizationId}/apply
- Route: POST /api/v1/candidate/optimizations/{optimizationId}/save-as-resume
- Type: JSON or multipart for file upload
- Used by: /dashboard/optimize, /dashboard/report, /dashboard/heatmap
- Primary frontend flow: use `optimization-flows` when the user uploads a CV and pastes a job description on the same screen.
- Lower-level flow: use `resumes` then `optimizations` only when a resume already exists in the library.
- Example `optimization-flows` multipart payload:

```json
{
  "file": "<binary-pdf-or-docx>",
  "name": "Software Engineer Resume",
  "job_description": "We are looking for a Senior Frontend Engineer...",
  "consume_credit": true
}
```

- Example create payload for an existing resume:

```json
{
  "resumeId": "res_123",
  "jobDescription": "We are looking for a Senior Frontend Engineer...",
  "targetRole": "Senior Frontend Engineer",
  "consumeCredit": true
}
```

Notes:

- Optimization creation now returns a queued optimization immediately.
- Frontend should poll `/status` until `completed` or `failed`.
- Saved optimized output should use `save-as-resume` so it appears as a new resume library version.
- Expected status values: `queued`, `extracting_resume`, `analyzing_resume`, `building_report`, `building_heatmap`, `completed`, `failed`.
- `/status` includes a `progress` integer from 0-100 for progress bars.
- Production deployment must run a queue worker because optimization processing is asynchronous.

Example normalized report response:

```json
{
  "id": 55,
  "status": "completed",
  "score": 91,
  "target_role": "Senior Frontend Engineer",
  "report": {
    "score": 91,
    "score_label": "excellent",
    "percentile_text": "Stronger than 88% of candidates",
    "summary": "Strong match with a few keyword gaps.",
    "keywords": {
      "matched": ["React", "TypeScript"],
      "partial": ["AWS"],
      "missing": ["Kubernetes"]
    },
    "sections": [
      {
        "key": "keyword_density",
        "title": "Keyword Density",
        "status": "good",
        "summary": "Matched 2/3 job description terms.",
        "tags": ["React", "TypeScript"]
      }
    ],
    "critical_fixes": [
      {
        "id": "fix_1",
        "title": "Add Kubernetes to skills section",
        "description": "This keyword appears in the target job description.",
        "section": "skills",
        "priority": "medium",
        "issue": "Missing Kubernetes keyword.",
        "suggested_text": "React, TypeScript, AWS, Kubernetes",
        "applied": false
      }
    ]
  }
}
```

Example normalized heatmap response:

```json
{
  "id": 55,
  "status": "completed",
  "score": 91,
  "heatmap": {
    "score": 91,
    "keyword_breakdown": {
      "matched": 2,
      "partial": 1,
      "missing": 1
    },
    "legend": [
      { "type": "strong", "label": "Strong Match" },
      { "type": "partial", "label": "Partial Match" },
      { "type": "missing", "label": "Missing" },
      { "type": "bonus", "label": "Bonus Keyword" }
    ],
    "resume_blocks": [
      {
        "section": "summary",
        "text": "Frontend engineer with React experience.",
        "tokens": [
          { "text": "React", "type": "strong" },
          { "text": "Kubernetes", "type": "missing" }
        ]
      }
    ],
    "missing_keywords": ["Kubernetes"]
  }
}
```

### 2.4.1 Candidate Credit History

- Route: GET /api/v1/candidate/credits/packs
- Route: GET /api/v1/candidate/credits/summary
- Route: GET /api/v1/candidate/credits/transactions
- Route: GET /api/v1/candidate/credits/transactions/{transactionId}
- Type: JSON
- Used by: candidate billing/usage history
- Example transaction shape:

```json
{
  "id": 91,
  "optimization_id": 55,
  "resume_name": "Software Engineer Resume",
  "amount": 1,
  "signed_amount": -1,
  "direction": "out",
  "balance_before": 3,
  "balance_after": 2,
  "type": "debit",
  "type_label": "Credit used",
  "source": "optimization",
  "source_label": "AI optimization",
  "transaction_category": "usage",
  "status": "used",
  "description": "AI optimization for Senior Frontend Engineer",
  "created_at": "2026-05-12T10:30:00Z"
}
```

- Credit pack purchases return `transaction_category: "purchase"` with `credit_purchase_id`, `credit_pack_id`, `credit_pack_name`, and a `payment` object containing gateway references.

### 2.5 Candidate Profile

- Route: GET /api/v1/candidate/profile
- Route: PATCH /api/v1/candidate/profile
- Route: PATCH /api/v1/candidate/profile/avatar
- Type: JSON
- Used by: /dashboard/profile
- Example payload:

```json
{
  "name": "Sarah Chen",
  "phone": "+1 (555) 000-0000",
  "headline": "Senior Software Engineer",
  "bio": "Experienced software engineer...",
  "location": "San Francisco, CA",
  "linkedin_url": "https://linkedin.com/in/sarahchen",
  "portfolio_url": "https://sarahchen.dev",
  "summary": "Experienced software engineer...",
  "job_preferences": {
    "desired_role": "Senior Frontend Engineer",
    "work_policy": "remote",
    "expected_salary_min": 140000,
    "expected_salary_max": 160000,
    "availability": "2_weeks"
  }
}
```

Profile picture upload:

- Method: `PATCH`
- Content-Type: `multipart/form-data`
- Field: `avatar` (image file)

### 2.6 Candidate Settings

- Route: PATCH /api/v1/candidate/security/password
- Route: PATCH /api/v1/candidate/settings/notifications
- Route: PATCH /api/v1/candidate/settings/appearance
- Route: DELETE /api/v1/candidate/account
- Type: JSON
- Used by: /dashboard/settings

Notification toggles accepted by `PATCH /api/v1/candidate/settings/notifications`:

- `resume_analysis_complete`
- `new_job_match_recommendations`
- `application_status_updates`
- `product_updates_tips`

### 2.7 Candidate Billing + Payment

- Route: GET /api/v1/candidate/billing/overview
- Route: GET /api/v1/candidate/billing/invoices
- Route: GET /api/v1/candidate/billing/invoices/{invoiceId}/download
- Route: POST /api/v1/candidate/credits/checkout
- Route: POST /api/v1/candidate/credits/purchases/{reference}/capture
- Route: POST /api/v1/candidate/payments/checkout-session
- Route: POST /api/v1/candidate/payments/credit-packs/checkout
- Route: POST /api/v1/candidate/payments/credit-packs/{reference}/capture
- Route: POST /api/v1/candidate/payments/offline-receipts
- Type: JSON and multipart
- Used by: /dashboard/billing, /payment/checkout, /payment/receipt
- Example credit checkout payload:

```json
{
  "credit_pack_id": 1,
  "payment_method_slug": "stripe"
}
```

- Example PayPal capture payload: empty JSON body after the buyer returns from PayPal approval; use the `reference` returned by checkout.
- Example offline receipt payload:

```json
{
  "planCode": "pro_monthly",
  "amount": 29,
  "currency": "USD",
  "referenceNumber": "BANK-2026-00119",
  "paidAt": "2026-03-20T15:30:00Z",
  "receiptFile": "<binary-image-or-pdf>",
  "notes": "Bank transfer"
}
```

## 3) Recruiter Dashboard Route Requirements

These come from pages under /recruiter.

### 3.1 Recruiter Dashboard Summary

- Route: GET /api/v1/recruiter/dashboard
- Type: JSON
- Used by: /recruiter

### 3.2 Company Settings

- Route: GET /api/v1/recruiter/company-profile
- Route: PATCH /api/v1/recruiter/company-profile
- Route: POST /api/v1/recruiter/company-profile/logo
- Route: PATCH /api/v1/recruiter/settings/notifications
- Type: JSON and multipart
- Used by: /recruiter/settings

### 3.3 Jobs Management

- Route: GET /api/v1/recruiter/jobs
- Route: POST /api/v1/recruiter/jobs
- Route: GET /api/v1/recruiter/jobs/{jobId}
- Route: PATCH /api/v1/recruiter/jobs/{jobId}
- Route: DELETE /api/v1/recruiter/jobs/{jobId}
- Type: JSON
- Used by: /recruiter/jobs, /recruiter/jobs/new
- Example create payload:

```json
{
  "title": "Senior Frontend Engineer",
  "department": "Engineering",
  "employmentType": "full_time",
  "workPolicy": "remote",
  "location": "New York, NY",
  "description": "Role details...",
  "experienceLevel": "mid",
  "requiredSkills": ["React", "TypeScript", "Node.js"],
  "mustHave": ["5+ years frontend"],
  "niceToHave": ["GraphQL"],
  "compensation": {
    "currency": "USD",
    "minSalary": 120000,
    "maxSalary": 160000
  },
  "benefits": ["Health Insurance", "Unlimited PTO"],
  "status": "draft"
}
```

### 3.4 Applicants + Ranking

- Route: GET /api/v1/recruiter/jobs/{jobId}/applicants
- Route: GET /api/v1/recruiter/jobs/{jobId}/applicants/stats
- Route: GET /api/v1/recruiter/applicants/{applicantId}
- Route: PATCH /api/v1/recruiter/applicants/{applicantId}/status
- Route: GET /api/v1/recruiter/applicants/{applicantId}/resume
- Type: JSON + file download
- Used by: /recruiter/applicants, /recruiter/applicants/[id]
- Example status update payload:

```json
{
  "status": "shortlisted",
  "note": "Strong ATS match"
}
```

### 3.5 Interview Scheduling

- Route: GET /api/v1/recruiter/interviews
- Route: POST /api/v1/recruiter/interviews
- Route: PATCH /api/v1/recruiter/interviews/{interviewId}
- Route: DELETE /api/v1/recruiter/interviews/{interviewId}
- Route: POST /api/v1/recruiter/interviews/{interviewId}/invite
- Type: JSON
- Used by: /recruiter/interviews
- Example create payload:

```json
{
  "applicantId": "app_123",
  "jobId": "job_456",
  "interviewType": "technical_round",
  "scheduledAt": "2026-03-24T14:00:00Z",
  "durationMinutes": 60,
  "platform": "google_meet",
  "timezone": "America/Los_Angeles"
}
```

### 3.6 Recruiter Billing

- Route: GET /api/v1/recruiter/billing/overview
- Route: GET /api/v1/recruiter/billing/plans
- Route: POST /api/v1/recruiter/billing/checkout
- Route: GET /api/v1/recruiter/billing/checkout/{reference}
- Route: PATCH /api/v1/recruiter/billing/subscription
- Route: DELETE /api/v1/recruiter/billing/subscription
- Route: GET /api/v1/recruiter/billing/invoices
- Route: GET /api/v1/recruiter/billing/invoices/{invoiceId}/download
- Route: GET /api/v1/recruiter/billing/payment-methods
- Route: POST /api/v1/recruiter/billing/payment-methods
- Type: JSON
- Used by: /recruiter/billing
- Example checkout payload:

```json
{
  "plan_code": "pro",
  "billing_cycle": "monthly",
  "payment_method_slug": "stripe"
}
```

### 3.7 Payment Webhooks

- Route: POST /api/v1/payments/webhooks/stripe
- Route: POST /api/v1/payments/webhooks/paypal
- Type: JSON
- Used by: Stripe and PayPal hosted checkout callbacks

## 4) Admin (Based on approval page)

### 4.1 Offline Payment Approval

- Route: GET /api/v1/admin/payments/offline-receipts
- Route: PATCH /api/v1/admin/payments/offline-receipts/{receiptId}
- Route: GET /api/v1/admin/payments/metrics
- Type: JSON
- Used by: /dashboard/approvals
- Example decision payload:

```json
{
  "decision": "approved",
  "reviewNote": "Verified with bank reference"
}
```

## 5) Public Site APIs (from existing pages)

### 5.1 Contact Form

- Route: POST /api/v1/contact/messages
- Type: JSON
- Used by: /(public)/contact
- Example payload:

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "subject": "Technical Support",
  "message": "I cannot upload my resume"
}
```

## 6) MVP Build Order (recommended)

1. Auth: login, register, forgot-password, reset-password, me, logout
2. Candidate core: resumes, optimize flow, report, heatmap, editor save/export
3. Candidate account: profile, settings, billing, checkout, offline receipt
4. Recruiter core: jobs, applicants, interviews
5. Recruiter settings + billing
6. Admin offline payment approvals
