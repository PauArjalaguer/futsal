<div class="row" id="content" style='padding:12px;'>
    <div  class="large-12 medium-12 columns">
        <div class="row">
            <h2> </h2>
            <div >
                <?php
                $large="";
                $medium="";
                $original="";
               
                $total = count($sizes->size);
                for ($a = 0; $a < $total; $a++) {
                    if ($sizes->size[$a]['label'] == "Medium") {
                        $medium = $sizes->size[$a]['source'];
                    }
                    if ($sizes->size[$a]['label'] == "Large") {
                        $large = $sizes->size[$a]['source'];
                    }
                    if ($sizes->size[$a]['label'] == "Original") {
                        $original = $sizes->size[$a]['source'];
                    }
                    if ($large) {
                        $url = "<a href='$large'>";
                    } else {
                        $url = "<a href='$original'>";
                    }
                    
                   
                }  $img = "<img src='$large'  width=100%>";echo $url . " " . $img . "</a>";
                ?>

            </div>
        </div>
    </div>
</div>