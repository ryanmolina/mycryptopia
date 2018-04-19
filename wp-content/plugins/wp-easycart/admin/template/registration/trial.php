<?php if( strtotime( date( 'Y-m-d', strtotime( wp_easycart_admin_license( )->license_data->support_end_date ) ) ) < strtotime( date( 'Y-m-d' ) ) ){ ?>
<div class="ec_admin_settings_panel">
    <div class="ec_admin_important_numbered_list_fullwidth">
        <div class="ec_admin_list_line_item_fullwidth ec_admin_demo_data_line">
			<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_registration_loader" ); ?>
            <div class="ec_admin_settings_label">
            	<div class="dashicons-before dashicons-lock"></div>
                <span>Your Trial has Ended</span>
			</div>
            <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
                <style>
                input {margin-top: 0px !important;}
                </style>
                <h3 style="font-size:32px; font-weight:normal; margin:0 0 10px; display:block;">Your Trial is Over. Upgrade Today!</h3>
                <ul style="list-style:inherit; padding:0 30px; line-height:1.5em;">
					<li>All EasyCart licenses are good for use on <strong>one</strong> WordPress website.</li>
					<li>You may easily transfer your website license to any other website by deactivating your license key.</li>  
					<li>You may also enter your license key into a new website and it will automatically transfer your license to the new site.</li>
				</ul>
				<p>Upgrade to PRO today to continue using WP EasyCart by purchasing a license at <a href="https://www.wpeasycart.com/wordpress-shopping-cart-pricing/" target="_blank">www.wpeasycart.com</a>.</p>
				
                <hr />
                <h3 style="font-size:32px; font-weight:normal; margin:25px 0 10px; display:block;">Activate Your PRO License</h3>
                <form action="admin.php?page=wp-easycart-registration&subpage=registration&ec_action=activateregistration"  method="POST" name="wpeasycart_admin_form" id="wpeasycart_admin_form1" novalidate="novalidate">
                	<div><span class="ec_language_row_label">Full Name (First & Last):</span><br /> <input type="text" name="customername" id="customername" required="required" ></div><br />
                	<div><span class="ec_language_row_label">Email Address:</span><br /> <input type="email" name="customeremail" id="customeremail" required="required" ></div><br />
                	<div><span class="ec_language_row_label">License Key:</span><br /> <input type="text" name="transactionkey" id="transactionkey" required="required" ></div><br />
                	<div class="ec_admin_settings_input" style="padding:0px;"><input type="submit" class="ec_admin_settings_simple_button"value="Activate EasyCart License"></div>
                </form>
            </div>
        </div>
    </div>
</div>
	
<?php }else{ ?>
<div class="ec_admin_settings_panel">
    <div class="ec_admin_important_numbered_list_fullwidth">
        <div class="ec_admin_list_line_item_fullwidth ec_admin_demo_data_line">
			<?php wp_easycart_admin( )->preloader->print_preloader( "ec_admin_registration_loader" ); ?>
            <div class="ec_admin_settings_label">
            	<div class="dashicons-before dashicons-admin-network"></div>
                <span>Your Trial is Activated</span>
			</div>
            <div class="ec_admin_settings_input ec_admin_settings_live_payment_section">
                <style>
                input {margin-top: 0px !important;}
                </style>
                <h3 style="font-size:32px; font-weight:normal; margin:0 0 10px; display:block;">Ready to Go PRO? Upgrade Now!</h3>
                <ul style="list-style:inherit; padding:0 30px; line-height:1.5em;">
					<li>All EasyCart licenses are good for use on <strong>one</strong> WordPress website.</li>
					<li>You may easily transfer your website license to any other website by deactivating your license key.</li>  
					<li>You may also enter your license key into a new website and it will automatically transfer your license to the new site.</li>
				</ul>
				<p>Upgrade to PRO today by purchasing a license at <a href="https://www.wpeasycart.com" target="_blank">www.wpeasycart.com</a>.</p>
				
                <hr />
                <h3 style="font-size:32px; font-weight:normal; margin:25px 0 10px; display:block;">Activate Your PRO License</h3>
                <form action="admin.php?page=wp-easycart-registration&subpage=registration&ec_action=activateregistration"  method="POST" name="wpeasycart_admin_form" id="wpeasycart_admin_form1" novalidate="novalidate">
                	<div><span class="ec_language_row_label">Full Name (First & Last):</span><br /> <input type="text" name="customername" id="customername" required="required" ></div><br />
                	<div><span class="ec_language_row_label">Email Address:</span><br /> <input type="email" name="customeremail" id="customeremail" required="required" ></div><br />
                	<div><span class="ec_language_row_label">License Key:</span><br /> <input type="text" name="transactionkey" id="transactionkey" required="required" ></div><br />
                	<div class="ec_admin_settings_input" style="padding:0px;"><input type="submit" class="ec_admin_settings_simple_button"value="Activate EasyCart License"></div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php }?>