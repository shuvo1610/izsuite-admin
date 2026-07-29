## App Category CRUD — Implementation Plan

Apps-এর হুবহু প্যাটার্নে একটি নতুন **App Category** CRUD তৈরি করা হবে। একমাত্র পার্থক্য: field শুধু `name` এবং `is_active`, এবং `is_active` এর জন্য **Roles-এর `.toggle-switch`** UI ব্যবহার করা হবে — সাথে index table-ে সরাসরি AJAX toggle।

**Fields:** `name` (string), `is_active` (boolean, default true)

### নতুন ফাইল (৯টি)

1. **`database/migrations/2025_01_01_000020_create_app_categories_table.php`**
   - `id`, `name` (string), `is_active` (boolean, default true), `timestamps`

2. **`app/Models/AppCategory.php`**
   - `$fillable = ['name', 'is_active']`, `$casts = ['is_active' => 'boolean']`
   - Model নাম `AppCategory` (নাম সংঘর্ষ এড়াতে, Application-এর মতো)

3. **`app/Repositories/AppCategoryRepository.php`**
   - `getPaginated(?string $search, int $perPage)` — search name, `->withQueryString()`
   - `find()`, `create()`, `update()`, `delete()`, `toggleActive(AppCategory)` — `is_active` flip করে save

4. **`app/Services/Admin/AppCategoryService.php`**
   - Repository inject করে, AppService-এর হুবহু কাঠামো + `toggleActive()` method

5. **`app/Http/Requests/Admin/StoreAppCategoryRequest.php`**
   - `name` required|string|max:255, `is_active` sometimes|boolean

6. **`app/Http/Controllers/Admin/AppCategoryController.php`**
   - AppController-এর প্যাটার্ন + `toggleActive(int $id)` method (StaffController::toggleStatus-এর মতো, `adminSuccess` দিয়ে)
   - `create()` এ খালি `AppCategory` instance পাঠাবে

7. **`resources/views/admin/app-categories/index.blade.php`**
   - Apps index-এর হুবহু ডিজাইন: search box + per_page dropdown
   - Table columns: #, Name, Active (**toggle-switch** — click করলে form submit বা AJAX দিয়ে `toggle-status` route-এ যাবে), Created, Actions (Edit/Delete)
   - toggle-switch: `<input type="checkbox" class="toggle-switch" onchange="this.form.submit()">` বা একটি ছোট form যা PATCH করে — Roles-এর `.toggle-switch` স্টাইল হুবহু

8. **`resources/views/admin/app-categories/_form.blade.php`**
   - `name` input (Apps-এর মতো)
   - `is_active` — `<input type="checkbox" class="toggle-switch" name="is_active">` (Roles-এর `_form.blade.php`-এর হুবহু markup)
   - `$isEdit = isset($appCategory) && $appCategory->exists`

9. **`resources/views/admin/app-categories/create.blade.php`** + **`edit.blade.php`**
   - Apps create/edit-এর হুবহু ডিজাইন (breadcrumb, page-title, page-subtitle, card, buttons বাইরে)

### সম্পাদনা (existing ফাইল, ২টি)

10. **`routes/admin.php`**
    - `use App\Http\Controllers\Admin\AppCategoryController;`
    - `Route::resource('app-categories', AppCategoryController::class)->except(['show'])->parameters(['app-categories' => 'id']);`
    - `Route::patch('/app-categories/{id}/toggle-status', [AppCategoryController::class, 'toggleActive'])->name('app-categories.toggle-status');`

11. **`resources/views/components/admin-sidebar.blade.php`**
    - **"Apps" মেনুর ঠিক নিচে** "App Categories" মেনু যোল (Lucide `folder` বা `tags` আইকন), `admin.app-categories.*` active state সহ

### অনুসরণ করা হবে যেসব existing প্যাটার্ন
- ✅ Apps CRUD এর সম্পূর্ণ কাঠামো (Controller → Service → Repository → Model)
- ✅ `.toggle-switch` CSS ক্লাস (Roles `_form.blade.php`-এ যেভাবে ব্যবহৃত)
- ✅ `toggleActive()` + `toggle-status` route (StaffController::toggleStatus-এর প্যাটার্ন)
- ✅ `adminSuccess()` response helper
- ✅ Apps index-এর search box + per_page dropdown
- ✅ `ActivityLogService::record()`, `<x-confirm-modal>`, breadcrumb, etc.

### Migration চালানো
সব ফাইল তৈরির পরে `php artisan migrate` চালানো হবে।