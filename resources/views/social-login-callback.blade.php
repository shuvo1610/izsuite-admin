<!DOCTYPE html>
<html>
<head><title>LinkedIn Callback</title></head>
<body>
<script>
    // Extract code and state from URL params
    const params = new URLSearchParams(window.location.search);
    const code  = params.get('code');
    const state = params.get('state');
    const error = params.get('error');

    // Send back to parent window
    if (window.opener) {
        window.opener.postMessage({
            type: 'linkedin_callback',
            code: code,
            state: state,
            error: error || params.get('error_description'),
        }, window.location.origin);
    }
</script>
</body>
</html>
