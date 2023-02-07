<?php

error_reporting(0);

require_once '../connection/connection.php';

    $get_user_code = mysqli_query($con,"select * from staff where email='".$_SESSION['email']."';");
    $user_code = mysqli_fetch_assoc($get_user_code);

    if($user_code['emp_code']=='E-1')
    {
        session_destroy();

        echo '<script>window.location.href="../login.php"</script>';
    }

    else
    {
        $views_query = mysqli_query($con,"select *,views.redirect_to,views.id as IID from allowed_views left join views on views.view_name=allowed_views.view_name where allowed_views.emp_code='".$user_code['emp_code']."';");
    }

    ?>
<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-dark gradient-45deg-deep-purple-blue sidenav-gradient sidenav-active-rounded">
        <div class="brand-sidebar">
        </div>
        <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
           
            <li class="navigation-header"><a class="navigation-header-text">Applications</a><i class="navigation-header-icon material-icons">more_horiz</i>
            </li>

            <?php

            $icon_class = ["patient_list","inpatient","output","verified_user","medication","warehouse","supervised_user_circle","request_page","labs","ward"];

            while($row = mysqli_fetch_assoc($views_query))
            {
                echo "<li class='bold'>
                <a class='navigation-header-text' href='../user/".$row['redirect_to']."'><span class='mb-1 material-symbols-outlined'>".$icon_class[$row['IID']-1]."</span>&nbsp;&nbsp;".$row['view_name']."</a><i class='navigation-header-icon material-icons'>more_horiz</i>
                </li>";
            }
            
            ?>
           
        </ul>
        <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
    </aside>