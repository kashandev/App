<header class="header">
    <a href="#" id="logo" class="logo">
        <h3><label class="text-center"><span style="color: white">B-</span><span style="color: #26a69a">F</span><span style="color: #5c6bc0">A</span><span style="color: #ff7043">S</span></label></h3>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <div class="responsive_nav"></div>
            </a>
        </div>
        <div class="navbar-right">
            <ul class="nav navbar-nav" style="display: flex;justify-content: center;align-items: center;gap: 10px;">
                <style>
                    .session-branch-name {
                        color: #fff !important;
                        font-weight: bold;
                        text-decoration: none !important;
                    }
                    .session-branch-name:hover {
                        background-color: transparent !important;
                     }
                </style>
                <li>
                    <a href="javascript:void();" class="session-branch-name"><?php echo $branch_name; ?></a>
                </li>
                <li class="dropdown user user-menu">
                    <button style="background: #505663;" type="button" class="btn btn-dark dropdown-toggle" id="user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    <style>
                        #user-dropdown:focus{
                            outline: none !important;
                            border: none !important;
                        }
                    </style>
                        <img src="<?php echo $user_image; ?>" width="35" class="img-circle img-responsive pull-left" height="35" alt="riot">
                        <div class="riot">
                            <div>
                                <?php echo $user_name; ?>
                                <span>
                                    <i class="caret"></i>
                                </span>
                            </div>
                        </div>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="user-dropdown" id="user-dropdown-menu">
                        <!-- User image -->
                        <li class="user-header" style="background: #505663;display: flex;align-items: center;justify-content: center;">
                            <img src="<?php echo $user_image; ?>" width="90" class="img-circle img-responsive" height="90" alt="User Image" />
                            <p><?php echo $user_name; ?></p>
                        </li>
                        <!-- Menu Body -->
                        <li>
                            <a href="<?php echo $href_user_profile; ?>">
                                <i class="livicon" data-name="user" data-s="18"></i> <?php echo $lang['my_profile']; ?>
                            </a>
                        </li>
                        <li role="presentation"></li>
                        <li>
                            <a href="<?php echo $href_logout; ?>">
                                <i class="livicon" data-name="sign-out" data-s="18"></i> <?php echo $lang['logout']; ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert-dismissable").slideUp(500);
        }, 5000);
    })

    $(function(){
        $('#user-dropdown').click(function(){
            $('#user-dropdown-menu').toggle('show');
        });
    });

</script>