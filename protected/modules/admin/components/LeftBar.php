<?php
class LeftBar extends CWidget
{
	public function showMenu()
	{
		// $this->widget('zii.widgets.jui.CJuiAccordion', array());
		// die('here');
		$this->widget('zii.widgets.jui.CJuiAccordion', array(
			'panels'=>array(
				'Dashboard'=>'<ul class="leftbar_menu">
								<li><a class="home" href="' .Yii::app()->getBaseUrl()."/index.php/admin/site/Index" . '">Home</a></li>
								<li><a class="bg" href="' . Yii::app()->getBaseUrl()."/index.php/admin/site/changePassword". '">Change Password</a></li>
								<li><a class="setting" href="' .Yii::app()->getBaseUrl()."/index.php/admin/site/setting".'">Site Settings</a></li>
								<li><a class="bg" href="' . Yii::app()->getBaseUrl()."/index.php/admin/site/background".'">Change Background</a></li>
								
								<li><a class="logout" href="' .Yii::app()->getBaseUrl()."/index.php/admin/site/logout".  '">Logout</a></li>
						   </ul>',
						   	   		   		   
						   
//				'Manage Users'=>'<ul class="leftbar_menu">
//								<li><a class="userlist" href="' . Yii::app()->createUrl("admin/users/admin") . '">All Users</a></li>
//								<li><a class="userlist" href="' . Yii::app()->createUrl("admin/cashoutRequests/admin") . '">Cashout Requests</a></li>
//								<!--<li><a class="useradd" href="#">Add New</a></li>
//								<li><a class="userprof" href="#">Your Profile</a></li>-->
//						   </ul>',
//			   
//			   'Manage Articles/Videos'=>'<ul class="leftbar_menu">
//					<li><a class="userlist" href="' . Yii::app()->createUrl("admin/articles/admin") . '">All Articles</a></li>
//					<li><a class="userlist" href="' . Yii::app()->createUrl("admin/videos/admin") . '">All Videos</a></li>
//					<li><a class="userlist" href="' . Yii::app()->createUrl("admin/comments/admin") . '">All Comments</a></li>
//					<!--<li><a class="useradd" href="' . Yii::app()->createUrl("admin/users/create") . '">Add New</a></li>
//					<li><a class="userprof" href="' . Yii::app()->createUrl("admin/users/update/id/" . Yii::app()->user->user_id . "") . '">Your Profile</a></li>-->
//			   </ul>',			   
//						   
//				'Manage Contents'=>'<ul class="leftbar_menu">
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/settings/update/id/1") . '">Option Settings</a></li>
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/categories/admin") . '">All Categories</a></li>
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/categories/create") . '">Add Category</a></li>
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/balloonText/admin") . '">Balloon Text</a></li>
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/balloonText/create") . '">Add Balloon Text</a></li>
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/static/aboutus") . '">About us</a></li>
//								<li><a class="conatct" href="' . Yii::app()->createUrl("admin/static/contactus") . '">Contact us</a></li>
//								<li><a class="privacy" href="' . Yii::app()->createUrl("admin/static/privacy") . '">Privacy</a></li>
//                                                                <li><a class="privacy" href="' . Yii::app()->createUrl("admin/static/links") . '">Links</a></li>
//								<li><a class="privacy" href="' . Yii::app()->createUrl("admin/faq/admin") . '">Manage FAQ</a></li>
//								<li><a class="privacy" href="' . Yii::app()->createUrl("admin/faq/create") . '">Add FAQ</a></li>
//                                                              <li><a class="privacy" href="' . Yii::app()->createUrl("admin/static/podcasts") . '">Podcasts</a></li>
//						   </ul>',
//						   
						   'Manage Contents'=>'<ul class="leftbar_menu">					
								
								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/static/textpage") . '">Text page</a></li>
								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/static/help") . '">Help Page</a></li>
								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/static/aboutus") . '">About us</a></li>
								<li><a class="conatct" href="' . Yii::app()->createUrl("admin/static/contactus") . '">Contact us</a></li>
								<li><a class="privacy" href="' . Yii::app()->createUrl("admin/static/privacy") . '">Privacy</a></li>
                                 <li><a class="privacy" href="' . Yii::app()->createUrl("admin/static/links") . '">Links</a></li>
								
								<li><a class="privacy" href="' . Yii::app()->createUrl("admin/faq/admin") . '">Manage FAQ</a></li>
								<li><a class="privacy" href="' . Yii::app()->createUrl("admin/faq/create") . '">Add FAQ</a></li>
                                                                
						   </ul>',
//				'community Messages'=>'<ul class="leftbar_menu">
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/communityMessage/admin") . '">Event Messages</a></li>
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/communityMessageToUser/sendMessage") . '">Message to User(s)</a></li>
//						   </ul>',
						   
//				'Manage Forum'=>'<ul class="leftbar_menu">
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/forumCategories/admin") . '">All Categories</a></li>
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/forumCategories/create") . '">Add Category</a></li>
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/forumThreads/admin") . '">All Threads</a></li>
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/forumThreads/create") . '">Create Thread</a></li>
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/forumComments/admin") . '">All Comments</a></li>
//						   </ul>',
                                                   
//                                'Manage Classifieds'=>'<ul class="leftbar_menu">
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/classifiedCategory/admin") . '">All Categories</a></li>
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/classifiedCategory/create") . '">Add Category</a></li>
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/classifieds/admin") . '">All Listings</a></li>
//						   </ul>',
                                                   
//                                'Manage Theater'=>'<ul class="leftbar_menu">
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/ManageTheater/settings") . '">Theater Option Settings</a></li>
//						   </ul>',
                                 'Manage Testimonials'=>'<ul class="leftbar_menu">
                                            <li><a class="aboutus" href="' .Yii::app()->getBaseUrl()."/index.php/admin/testimonial/admin".  '">All Testimonials</a></li>
                                            <li><a class="aboutus" href="' .Yii::app()->getBaseUrl()."/index.php/admin/testimonial/create".  '">Add Testimonial</a></li>
                               </ul>',
                              'Manage Users'=>'<ul class="leftbar_menu">
                                            <li><a class="aboutus" href="' .Yii::app()->getBaseUrl()."/index.php/admin/user/admin".  '">All Users</a></li>
                                            <li><a class="aboutus" href="' .Yii::app()->getBaseUrl()."/index.php/admin/user/create".  '">Add User</a></li>
                               </ul>',
                                 'Manage Tranlation'=>'<ul class="leftbar_menu">
                                            <li><a class="aboutus" href="' .Yii::app()->getBaseUrl()."/index.php/admin/Translation/admin".  '">All Translations</a></li>
                                            <li><a class="aboutus" href="' .Yii::app()->getBaseUrl()."/index.php/admin/Translation/create".  '">Add translation</a></li>
                               </ul>',
                             'Manage Goals'=>'<ul class="leftbar_menu">
                                            <li><a class="aboutus" href="' .Yii::app()->getBaseUrl()."/index.php/admin/goal/admin".  '">All Goal</a></li>
                                            <li><a class="aboutus" href="' .Yii::app()->getBaseUrl()."/index.php/admin/goal/create".  '">Add goal</a></li>
                                            <li><a class="aboutus" href="' . Yii::app()->createUrl("admin/categories/admin") . '">All Categories</a></li>
                                            <li><a class="aboutus" href="' . Yii::app()->createUrl("admin/categories/create") . '">Add Category</a></li>
                                            <li><a class="aboutus" href="' .Yii::app()->getBaseUrl()."/index.php/admin/tag/admin".  '">All Tags</a></li>
                                            <li><a class="aboutus" href="' .Yii::app()->getBaseUrl()."/index.php/admin/tag/create".  '">Add Tag</a></li>
                                            <li><a class="aboutus" href="' .Yii::app()->getBaseUrl()."/index.php/admin/comment/index".  '">Manage Comments</a></li>
                               </ul>',
                                'Manage Feedbacks'=>'<ul class="leftbar_menu">
                                            <li><a class="aboutus" href="' .Yii::app()->getBaseUrl()."/index.php/admin/feedback/admin".  '">All Feedbacks</a></li>
											 <li><a class="aboutus" href="' .Yii::app()->getBaseUrl()."/index.php/admin/feedback/create".  '">Add Feedback</a></li>
                               </ul>',
                                'Manage Blog'=>'<ul class="leftbar_menu">
                                            <li><a class="aboutus" href="' .Yii::app()->getBaseUrl()."/index.php/admin/blogposts".  '">Go to Blog</a></li>
                               </ul>',
//                                'Manage VHS Covers'=>'<ul class="leftbar_menu">
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/vhsCategory/admin") . '">All Categories</a></li>
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/vhsCategory/create") . '">Add Category</a></li>
//								<li><a class="aboutus" href="' . Yii::app()->createUrl("admin/vhsCovers/admin") . '">All VHS Covers</a></li>
//						   </ul>',
				),
				// additional javascript options for the accordion plugin
				'options'=>array(
					'animated'=>'bounceslide',
					'autoHeight'=> false,
					'navigation'=> true,
					//'class' => 'active',
				),
		));
	}
}
?>