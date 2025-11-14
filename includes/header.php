<?php
error_reporting(0);
require_once __DIR__ . '/auth.php';
$user = current_user();
?>
<!doctype html>
    <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="icon" type="image/x-icon" href="/lead_portal/public/assets/images/logo.png">
    <link rel="stylesheet" href="/lead_portal/public/assets/css/header.css">
    <title>Lead Management Portal</title>
</head>
<body>
    <?php if($user['access_level']==1): ?>
     <link rel="stylesheet" href="/Lead_portal/public/Assets/css/admin.css">
     <link rel="stylesheet" href="/Lead_portal/public/Assets/css/add_user.css">   
    <?php endif; ?>
    <?php if($user['access_level']==2): ?>
     <link rel="stylesheet" href="/Lead_portal/public/Assets/css/manager.css"> 
     <link rel="stylesheet" href="/Lead_portal/public/Assets/css/manager_upload_csv.css">
     <link rel="stylesheet" href="/Lead_portal/public/Assets/css/header.css">  
    <?php endif; ?>
    <?php if($user['access_level']==3): ?>
     <link rel="stylesheet" href="/Lead_portal/public/Assets/css/team_lead.css">   
     <link rel="stylesheet" href="/Lead_portal/public/Assets/css/lead_list/teamlead_upload_csv.css">   
    <?php endif; ?>
    <?php if($user['access_level']==4): ?>
     <link rel="stylesheet" href="/Lead_portal/public/Assets/css/csr.css">   
    <?php endif; ?>
<header class="site-header">
    <div class="container header-inner">
        <div class="brand">
            <div class="img-div" >
                <img style="height: 50px;" src="/Lead_portal/public/assets/images/logo.png" alt="logo" class="logo"/>
            </div>
            <div>
            <h1>Lead Portal</h1>
            <p class="muted">Lead Management System</p>
            </div>
        </div>
        <nav class="nav">
            <?php if($user): ?>
            <span class="nav-user">Hello, <?php echo esc($user['username']); ?></span>
            <a class="btn" href="dashboard">Dashboard</a>
            <a class="btn" href="lead_list">Leads</a>
            <a class="btn" href="lead_data">Leads Data</a>
            <?php if($user['access_level']==3): ?><a class="btn active" href="assign_team">Assign Team</a><?php endif; ?>
            <?php if($user['access_level']==2): ?><a class="btn" href="assign_team">Assign Team</a><?php endif; ?>
            <?php if($user['access_level']==1): ?>
                <a class="btn" href="add_lead">Add lead</a>
                <a class="btn" href="admin_user">Users</a>
                <a class="btn" href="file_data">File Data</a>
                <?php endif; ?>
            <a class="btn btn-ghost" href="logout">Logout</a>
            <?php else: ?>
            <a style="display: none;" class="btn" href="index">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container main"></main>
<!-- <script>
window.history.pushState(null, "", window.location.href);
window.onpopstate = function () 
{
    window.history.pushState(null, "", window.location.href);
};
</script> -->
