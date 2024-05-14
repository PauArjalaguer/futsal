<div class="row" id="content" style='padding:12px;'>
    <div  class="large-12 medium-12 columns">
        <div class="row">
            <style>
                .video-container {
	position:relative;
	padding-bottom:56.25%;
	padding-top:30px;
	height:0;
	overflow:hidden;
}

.video-container iframe, .video-container object, .video-container embed {
	position:absolute;
	top:0;
	left:0;
	width:100%;
	height:100%;
}
            </style>
            <h2><?php echo $title; ?> </h2>
            <div class='video-container'>
                <?php
               if($website=='youtube'){
                   echo "<iframe width=\"100%\" height=\"100%\" src=\"https://www.youtube.com/embed/".$code."\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>";
               }else if($website=='vimeo'){
                   echo "<iframe src=\"//player.vimeo.com/video/".$code."?byline=0&amp;portrait=0\" width=\"100%\" height=\"100%\" frameborder=\"0\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
               }
               
                       
                ?>
            </div>
        </div>
    </div>
</div>