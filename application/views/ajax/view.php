<?php /*
	Filename: 	    view.php
	Location: 	    /application/ajax/view
	Author: 		Matt Lantz
*/ ?>

<link type="text/css" href="../../../css/jquery-ui.css" lang="EN" dir="ltr" rel="stylesheet" />
<link type="text/css" href="../../../css/style.css" lang="EN" dir="ltr" rel="stylesheet" />
<link href='http://fonts.googleapis.com/css?family=Londrina+Solid|Doppio+One|Alfa+Slab+One' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href="../../../css/sliditron2000.css">
<link rel="stylesheet" type="text/css" href="../../../css/prettyPhoto.css" media="screen" /> 

<script type="text/javascript" src="../../../js/jquery.min.js"></script>
<script type="text/javascript" src="../../../js/sliditron2000.js"></script>
<script type="text/javascript" src="../../../js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../../js/jquery.cycle.all.min.js"></script>

<script type="text/javascript" src="../../../js/jquery.blowfish.js"></script>

<script>

    $(document.body).prepend(
        '<style>#xBox{cursor: pointer; width: 30px; height: 30px; border-radius: 18px; background: #111; border: 3px solid #fff; float: right; margin: -22px -22px 0 0; position: relative; z-index: 4000; box-shadow: 0 5px 20px #111;}</style>'+
        
        '<div id="Lbox" style="display: none; width: 100%; height: 100%; position: fixed; top: 0; left: 0; z-index: 100; background: #000; opacity:0.7; filter:alpha(opacity=70);"></div>'+            
        '<div id="LboxOuter" style="width: 750px; position: fixed; top: 0; left: 50%; z-index: 1000; border: #111 solid 15px; background: #fff; border-radius: 5px; margin-top: 50px; margin-left: -375px; display: none;">'+
        '<div id="xBox" onClick="$(\'#Lbox\').hide(); $(\'#LboxOuter\').hide()"><span id="micon-close" style="font-family: arial; font-size: 18px; line-height: 30px; font-weight: 900; color: #FFF; margin-left: 8px;">X</span></div>'+
        '<div id="LboxInner" style="float: left; width: 100%; margin-top: -15px; margin-bottom: -5px;"></div>'+
        '</div>');

</script>

<style>
   
    body{
        background: #fff;
    }
    ul{
        margin-left: 30px;
    }

</style>

<div class="wide_box" style="margin-top: 20px;">
        
	<div id="slideshow">
                
        <div id="slidesContainer">
			
            <?php foreach($gallery as $cat_gallery): ?>

            <script>
                $(document).ready(function(){
                    $('#galleryBox_<?php echo $cat_gallery->gallery_id; ?>').blowfish();
                });
            </script>

                <div class="slide">
                    
                    <div class="half_box">
                        <div class="padded">
                            <p><b style="font-size: 32px; line-height: 40px;"><?php echo $cat_gallery->gallery_name; ?></b></p>
                            <p><b style="color: #111;">Company: <?php echo $cat_gallery->gallery_company; ?></p></b>
                            <p><b style="color: #111;">Truck Model: <?php echo $cat_gallery->gallery_tmodel; ?></p></b>
                            <p><b style="color: #111;">Engine Model: <?php echo $cat_gallery->gallery_emodel; ?></p></b>
                            <p><b style="color: #111;">Fuel Milage: <?php echo $cat_gallery->gallery_fmilage; ?></p></b>
                            <p><?php echo $cat_gallery->gallery_entry; ?></p>
                        </div>
                    </div>

                    <div class="half_box">

                        <div id="galleryBox_<?php echo $cat_gallery->gallery_id; ?>" style="margin-top: 40px;">

                            <?php 

                                $id = $cat_gallery->gallery_id;

                                $sql = "SELECT * FROM img WHERE blog_id = ".$id." ORDER BY favorite desc"; 
                                $qry = mysql_query($sql);
                                while($row = mysql_fetch_assoc($qry)){ 
                                    echo '<img src="../../'.$row['img_location'].'" />';
                                }
                            ?>

                        </div>
        
                    </div>
               
                </div>
                           		                
            <?php endforeach; ?>                    
						   
        </div>
   
    </div>

</div>
	
<!-- End of File -->