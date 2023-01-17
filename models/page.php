<?php
//START for review section
$rev_html = '';
//Get review list
$review_list_data = get_review_list_data(1,8);
if(!empty($review_list_data)) {
$rev_html .= '<section class="customer-reviews">';
$rev_html .= '<div class="container">';
  $rev_html .= '<div class="row">';
	$rev_html .= '<div class="col-md-12">';
	  $rev_html .= '<div class="block block-head text-center">';
		$rev_html .= '<h3>Customer Testimonies</h3>';
		$rev_html .= '<p>What our customer say about us !</p>';
	  $rev_html .= '</div>';
	$rev_html .= '</div>';
  $rev_html .= '</div>';
  $rev_html .= '<div class="swiper-container review-swiper">';
	$rev_html .= '<div class="swiper-wrapper">';
	  foreach($review_list_data as $key => $review_data) {
		  $rev_html .= '<div class="swiper-slide review-item">';
			$rev_html .= '<h4>'.$review_data['title'].'</h4>';
			$rev_html .= '<p>'.$review_data['content'].'</p>';
			$rev_html .= '<div class="rev-name">'.$review_data['name'].'</div>';
			$rev_html .= '<div class="review-stars">';
				if($review_data['stars'] == '0.5' || $review_data['stars'] == '1') {
					$rev_html .= '<i class="fas fa-star"></i>';
				} elseif($review_data['stars'] == '1.5' || $review_data['stars'] == '2') {
					$rev_html .= '<i class="fas fa-star"></i><i class="fas fa-star"></i>';
				} elseif($review_data['stars'] == '2.5' || $review_data['stars'] == '3') {
					$rev_html .= '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
				} elseif($review_data['stars'] == '3.5' || $review_data['stars'] == '4') {
					$rev_html .= '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
				} elseif($review_data['stars'] == '4.5' || $review_data['stars'] == '5') {
					$rev_html .= '<i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>';
				}
			$rev_html .= '</div>';
		  $rev_html .= '</div>';
	  }
	$rev_html .= '</div>';
	$rev_html .= '<div class="swiper-pagination"></div>';
  $rev_html .= '</div>';
$rev_html .= '</div>';
$rev_html .= '</section>';
}
//END for review section
if($rev_html!="") {
	$active_page_data['content'] = str_replace("[reviews]",$rev_html,$active_page_data['content']);
}

//START for faqs
$faqs_data_html = get_faqs_with_html();
if($faqs_data_html['html']!="") {
	$active_page_data['content'] = str_replace("[faqs]",$faqs_data_html['html'],$active_page_data['content']);
} else {
	$active_page_data['content'] = str_replace("[faqs]",'',$active_page_data['content']);
} //END for faqs

//START for faqs/groups
$faqs_groups_data_html = get_faqs_groups_with_html();
if($faqs_groups_data_html['html']!="") {
	$active_page_data['content'] = str_replace("[faqs_groups]",$faqs_groups_data_html['html'],$active_page_data['content']);
} else {
	$active_page_data['content'] = str_replace("[faqs_groups]",'',$active_page_data['content']);
} //END for faqs/groups
?>