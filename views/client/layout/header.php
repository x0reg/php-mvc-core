<?php
if (!$_SESSION['users']) {
    return redirect("/auth/login");
}
?>
<!DOCTYPE html>
<html lang="zxx" dir="ltr" class="light semiDark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <title>WEB DEMO</title>
    <link rel="icon" type="image/png" href="/public/images/logo/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" href="/public/css/rt-plugins.css">
    <link rel="stylesheet" href="/public/css/app.css">
    <!-- End : Theme CSS-->
    <script src="/public/js/settings.js"></script>
</head>
<style>
    input[type="radio"]:checked+label {
        border: 2px solid green;
        box-shadow: 0 0 10px green, 0 0 10px rgba(128, 128, 128, 0.5);
    }

    input[type="radio"]:checked+label .text-sm span {
        background-color: red;
        color: white;
    }

    input[type="radio"]:checked+label .text-lg,
    input[type="radio"]:checked+label .text-lg span {
        color: blue;
    }

    .fixtab {
        --tw-border-opacity: 1;
        border-color: rgb(241 245 249 / var(--tw-border-opacity));
        padding-left: 0.5rem;
        padding-right: 1.5rem;
        padding-top: 1rem;
        padding-bottom: 0.25rem;
        font-size: 0.875rem;
        line-height: 1rem;
        font-weight: 400;
    }

    .fixtr {
        padding-top: 1.05rem;
        padding-bottom: 0.55rem;
        padding-left: 2.5rem;
        padding-right: 1.5rem;
        font-size: 0.75rem;
        line-height: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        --tw-text-opacity: 1;
        color: rgb(71 85 105 / var(--tw-text-opacity));
    }
</style>