<div class="clearfix">
    <div class="text-center logo"><img src="images/logo.png" alt="" style="max-width:95%;"></div>
</div>
<div id="sidebar">    
    <ul>
        <li <?php if($page=="dashboard"){ print 'class="active"'; } ?>><a href="dashboard.php" style="border:none !important;"><img src="images/Cms_dashboard.png" alt=""><span>Dashboard</span></a> 
        </li>
           <li class="submenu <?php if($page=="home"){ print 'active open'; } ?>"> <a href="#"><img src="images/Cms_pages.png" alt=""><span>Manage Home Page</span></a>
            <ul>
                <li><a href="mng_list_banner.php">Manage Banner</a></li>    
                <li><a href="mng_home_text.php">Manage Home Text</a></li>    
                <li><a href="mng_our_services.php">Manage Our Services Text</a></li> 
                <li><a href="mng_home_services.php">Manage Our Services List</a></li> 
                <li><a href="mng_brand_text.php">Manage Brand Text</a></li> 
                <li><a href="mng_brand_images_list.php">Manage Brand Images</a></li>
                <li><a href="mng_request_quote.php">Manage Request Quote</a></li>              
                <li><a href="mng_banner_anim.php">Manage Banner Animation</a></li>              
         
               
                
            </ul>
        </li>
              <li class="submenu <?php if($page==$pg){ print 'active open'; } ?>"> <a href="#"><img src="images/Cms_pages.png" alt=""><span>Manage Banners</span></a>
            <ul>
                <li><a href="mng_inner_banners.php?page=aboutbanner">About Us Banner</a></li>    
                <li><a href="mng_inner_banners.php?page=newsbanner">News Banner</a></li> 
                <li><a href="mng_inner_banners.php?page=categorybanner">Category Banner</a></li> 
               <!--  <li><a href="mng_inner_banners.php?page=globalsourcingbanner">Global Sourcing Banner</a></li>  -->
                <li><a href="mng_inner_banners.php?page=industriesbanner">Industries Banner</a></li> 
                <li><a href="mng_inner_banners.php?page=linecardbanner">LineCard Banner</a></li> 
                <li><a href="mng_inner_banners.php?page=partsearchbanner">PartSearch Banner</a></li> 
                <li><a href="mng_inner_banners.php?page=productdetailsbanner">Product Details Banner</a></li> 
                <li><a href="mng_inner_banners.php?page=qualitybanner">Quality Banner</a></li>
                <li><a href="mng_inner_banners.php?page=requestquotebanner">Request Quote Banner</a></li>
                <li><a href="mng_inner_banners.php?page=inventarybanner">Excess Inventary Banner</a></li>
                <li><a href="mng_inner_banners.php?page=servicesbanner">Services Banner</a></li>
                <li><a href="mng_inner_banners.php?page=manufacturer">Manufacturer Banner</a></li>
                <li><a href="mng_inner_banners.php?page=privacy">Privacy Policy</a></li>
                <li><a href="mng_inner_banners.php?page=terms">Terms & Conditions</a></li>
            </ul>
        </li>
        <li class="submenu <?php if($page=="pages"){ print 'active open'; } ?>"> <a href="#"><img src="images/Cms_pages.png" alt=""><span>CMS Pages</span></a>
            <ul>
                <li><a href="mng_aboutus.php">Manage About Us</a></li>
                 <li><a href="mng_quality.php">Manage Quality</a></li>
                 <li><a href="mng_line_card.php">Manage Line Card</a></li>
                 <li><a href="mng_sell_excess_inventary.php">Manage Excess Inventary</a></li>
                 <li><a href="mng_privacy_policy.php">Manage Privacy Policy</a></li>
                 <li><a href="mng_terms_conditions.php">Manage Terms & Conditions</a></li>
                 <li><a href="mng_pages.php">Create Page</a></li>
                 <li><a href="mng_menu.php">Manage Menu</a></li>
            </ul>
        </li>
        <li class="submenu <?php if($page=="blog"){ print 'active open'; } ?>"> <a href="#"><img src="images/Cms_pages.png" alt=""><span>News Page</span></a>
            <ul>
                <li><a href="mng_list_blog.php">Manage News</a></li>
            </ul>
        </li>
       
      <li class="submenu <?php if($page=="services"){ print 'active open'; } ?>"> <a href="#"><img src="images/Cms_pages.png" alt=""><span>Manage Services</span></a>
            <ul>
                <li><a href="mng_services_landing.php">Services Landing Page</a></li>
                <li><a href="mng_services.php">Services </a></li>
            </ul>
        </li>
		
        <li class="submenu <?php if($page=="industries"){ print 'active open'; } ?>"> <a href="#"><img src="images/Cms_pages.png" alt=""><span>Manage Industries</span></a>
            <ul>
                <li><a href="mng_industries_landing.php">Industries Landing Page</a></li>
                <li><a href="mng_industries.php">Industries</a></li>
               
            </ul>
        </li>
          
		<li class="submenu <?php if($page=="quoterequest"){ print 'active open'; } ?>"> <a href="#"><img src="images/Cms_pages.png" alt=""><span>Request a Quote</span></a>
            <ul>
                <li><a href="mng_quote_landing.php">Quote Landing Page</a></li>
                <li><a href="mng_needby.php">Need By</a></li>
               
            </ul>
        </li>
  

     <li class="submenu <?php if($page=="mseo"){ print 'active open'; } ?>"> <a href="#"><img src="images/Cms_pages.png" alt=""><span>Manage SEO</span></a>
            <ul>
                 <li><a href="manage_seo.php?page=landing-page">Landing Page</a></li>
                 <li><a href="manage_seo.php?page=parts-search">Parts Search</a></li>
                 <li><a href="manage_seo.php?page=product-detail">Product Detail</a></li>
                  <li><a href="manage_seo.php?page=news">News</a></li>
                  <li><a href="manage_seo.php?page=manufacturer">Manufacturer</a></li>
            </ul>
        </li>
          <li class="submenu <?php if($page=="actionbar"){ print 'active open'; } ?>"> <a href="#"><img src="images/Cms_pages.png" alt=""><span>Action Bar</span></a>
            <ul>
                  <li><a href="mng_action_bar.php">Manage Action Bar</a></li>
                  
               
            </ul>
        </li>
       <li class="submenu <?php if($page=="contactus"){ print 'active open'; } ?>"> <a href="#"><img src="images/Cms_pages.png" alt=""><span>Manage Contact Us</span></a>
            <ul>
                  <li><a href="mng_contact_us.php">Contact Us</a></li>
                  <li><a href="mng_technical_support.php">Technical Support</a></li>
               
            </ul>
        </li>
		
		<li><a href="mng_manufacturers.php"><img src="images/Cms_pages.png" alt=""><span>Manage Manufacturers</span></a>
        </li>
		
		<li><a href="mng_products.php"><img src="images/Cms_pages.png" alt=""><span>Manage Products</span></a>
        </li>
		
		<li><a href="view_excess_inventary.php"><img src="images/Cms_pages.png" alt=""><span>View Excess Inventory</span></a>
        </li>
		
		<li><a href="view_request_quote.php"><img src="images/Cms_pages.png" alt=""><span>View Request a Quote</span></a>
        </li>
		
     
      
        <li class="submenu <?php if($page=="newpwd"){ print 'active open'; } ?>"> <a href="#"><img src="images/Cms_setting.png" alt=""><span>Settings</span></a>
            <ul>
                <li><a href="changepassword.php">Change Password</a></li>
                <li><a href="mng_footer_area.php">Manage Footer Area</a></li>
                <li><a href="mng_social_links.php">Manage Social links</a></li>
                <li><a href="mng_interestedin.php">Manage Interested In</a></li>
                <!--<li><a href="mng_google_key.php">Manage Google Key</a></li> -->
                
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </li>
    </ul>
</div>
<div class="clearfix" style="float:left;">
    <div id="footer">Copyright © <?php echo date('Y');?> Intransit. <a href=" https://www.thoughtmedia.com/clients/submitticket.php?step=2&deptid=1
" target="_blank">Get Support.</a>
    </div>
</div>
