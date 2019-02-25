<?php
/**
 * @package GOTB_Job_Notifier
 * @version 1.0.0
 */
/*
Plugin Name: GOTB Job Notifier
Plugin URI: http://www.geeksonthebeach.ca/
Description: Sends a notification to employer when they submit a job.
Version: 1.0.0
Author: Shannon Graham
Author URI: http://www.rocketships.ca/
License: GPLv2 or later
Text Domain: gotb-jobs
Domain Path: /languages/
*/
/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
*/

	/**
	 * Send a notification to job submitter about approved listing.
	 * @param $post_id
	 */
	function gotb_listing_published_notify( $post_id ) {

		if ( 'job_listing' !== get_post_type( $post_id ) ) {
			return;
		}

		$post   = get_post( $post_id );
		$author = get_userdata( $post->post_author );
		$headers = array('Content-Type: text/html; charset=UTF-8');

		$subject = __( sprintf( "Your job listing is online - %s", $post->post_title ), 'gotb' );

		$message = __( sprintf( "Your job posting, %s has been approved and is now posted on the Career Centre website. %s
		
Please note all jobs expire after 30 days. If you have hired for the position prior to the expiry date, please go into your account and mark the job as filled. %s
 
Please contact Diana Jolly, our Employer Services Coordinator at 250.248.3205 ext. 236 if you would like information about the Wage Subsidy Program or other services we provide for employers. %s
 
Many thanks, %s
Career Centre Team", "<a href='" . esc_html( get_permalink( $post_id ) ) . "'>" . esc_html( $post->post_title ) . "</a>","<br><br>", "<br><br>", "<br><br>", "<br><br>" ), 'gotb' );

		wp_mail( $author->user_email, $subject, $message, $headers );
	}
	add_action( 'pending_to_publish', 'gotb_listing_published_notify' );

	/**
	 * Send a notification to job submitter about submitted listing.
	 * @param $post_id
	 */
	function gotb_listing_submitted_notify( $post_id ) {

		if ( 'job_listing' !== get_post_type( $post_id ) ) {
			return;
		}

		$post   = get_post( $post_id );
		$author = get_userdata( $post->post_author );
		$headers = array('Content-Type: text/html; charset=UTF-8');

		$subject = __( sprintf( "New job submitted - %s", $post->post_title ), 'gotb' );

		$message = __( "Thank you for submitting your \"" . esc_html( $post->post_title ) . "\" job posting on the Career Centre website. <br><br>

Our staff will review your submission and ensure it is posted as soon as possible. In the event amendments are required, please allow 24 hours for the necessary changes to be made. Please take the time to visit our website and view your posting.<br><br>
If you have any questions or concerns, please contact us at <a target='_blank'>250.248.3205</a> or email <a href='mailto:reception@careercentre.org' target='_blank'>reception@careercentre.org</a> Monday to Friday from 8:30am to 4:30pm.<br><br>

<a href='http://www.careercentre.org/wage-subsidy/'>Click here</a> to find information on the wage subsidy program we currently administer. If you require more information or assistance with your hiring needs, please feel free to call or email us.<br><br>

<b>Who will join your team in 2019? Our Hiring Fair gives you access to hundreds of job seekers – the perfect opportunity to recruit for your team!</b> Join us at the Hiring Fair on Thursday April 11th, 2019 from 12–4 pm at the Parksville Community & Conference Centre!  The early bird rate to register ends March 1th at 5:00pm. Click <a href='https://www.careercentre.org/hiring-fair/'>here</a> to register now to take advantage of the Early Bird Rate! There are over 500 job seekers ready to meet you! <br><br>

Did you know that there are many benefits to hiring people with disabilities including:<br><br>
1. Improved Productivity – Research shows that diverse and inclusive workplaces are:<br>
- 2x more likely to meet or exceed financial targets<br>
- 6x more likely to be innovative<br>
- 6x more likely to effectively anticipate change<br><br>
2. People with Disabilities Make Great Employees  – Among employees with disabilities:<br>
- Staff retention was 72% higher<br>
- 86% had average or better attendance<br>
- 90% performed equal or better than their coworkers without disabilities<br><br>
3. Expanded Consumer Reach<br>
- The spending power of people with disabilities is over $55 billion dollars<br>
- 90% of consumers prefer to engage with companies that hire people with disabilities<br><br>

For more info see <a href='http://accessibleemployers.ca/business-case/'>accessibleemployers.ca/business-case/</a> and call a member of our Employer Services Team for assistance to hire your next great employee.
<br><br>
Many thanks,<br><br>
Career Centre Team
<hr />
<br><br>", 'gotb' );

		wp_mail( $author->user_email, $subject, $message, $headers );
	}
	add_action( 'preview_to_pending', 'gotb_listing_submitted_notify' );

	/**
	 * Send a notification to job submitter about expired listing.
	 * @param $post_id
	 */
	function gotb_listing_expired_notify( $post_id ) {
		if ( 'job_listing' !== get_post_type( $post_id ) ) {
			return;
		}

		$post   = get_post( $post_id );
		$author = get_userdata( $post->post_author );
		$headers = array('Content-Type: text/html; charset=UTF-8');

		$subject = __( sprintf( "Listing expired - %s", esc_html( $post->post_title ) ), 'gotb' );

		$message = __( sprintf( "Hi %s, <br><br>", $author->display_name ), 'gotb' );

		$message .= __( "Please note your job listing has now expired. 
<br><br> 
If you would like to repost this position, please sign onto our website and use your dashboard to manage your posting. 
<br><br>
<a href='http://www.careercentre.org/postajob/'>http://www.careercentre.org/postajob/</a> 
<br><br> 
If you require further assistance with your hiring needs, please feel free to contact me or check out our many <a href='http://www.careercentre.org/other-employer-resources/'>resources for employers </a> 
<br><br>
Thank you for posting with us, <br>
Diana Jolly, <br>
Employer Services Coordinator <br> 
250.248.3205 Ext. 236" , 'gotb' );

		wp_mail( $author->user_email, $subject, $message, $headers );

	}
	add_action( 'publish_to_expired', 'gotb_listing_expired_notify' );


	/**
	 * Filter From value for job manager notifications.
	 *
	 * @since 1.31.0
	 *
	 * @param mixed                $email_field_value Value to be filtered.
	 * @param WP_Job_Manager_Email $email             Email notification object.
	 */
	function change_sender() {
		return "diana@careercentre.org";

	}
	add_filter( 'job_manager_email_admin_new_job_from', 'change_sender' );

	/**
	 * Filter To value for job manager notifications.
	 *
	 * @since 1.31.0
	 *
	 * @param mixed                $email_field_value Value to be filtered.
	 * @param WP_Job_Manager_Email $email             Email notification object.
	 */
	function change_recipient() {
		return "jobpostings@careercentre.org";
	}
	add_filter( 'job_manager_email_admin_new_job_to', 'change_recipient' );

	/**
	 * Filter CC value for job manager notifications.
	 *
	 * @since 1.31.0
	 *
	 * @param mixed                $email_field_value Value to be filtered.
	 * @param WP_Job_Manager_Email $email             Email notification object.
	 */
	function add_cc() {
		return "shannon@geeksonthebeach.ca";
	}

	add_filter( 'job_manager_email_admin_new_job_cc', 'add_cc' );