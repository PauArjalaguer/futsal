<aside class="left-side sidebar-offcanvas">
    <section class="sidebar">
        <ul class="sidebar-menu">                   
            <?php
            $a = 0;
            foreach ($get_user_permissions as $row):
                if ($topSection != $row->topSection) {
                    $a++;
                    if ($a > 1) {
                        echo "\n\t\t\t\t\t</ul>\n\t\t\t\t</li>";
                    }
                    echo "\n\t\t\t\t<li class=\"treeview\">";
                    echo "\n\t\t\t\t\t<a href=\"#\">";
                    echo "\n\t\t\t\t\t\t<i class=\"" . $row->cssClass . "\"></i>";
                    echo "\n\t\t\t\t\t\t<span>" . $row->topSection . "</span>";
                    echo "\n\t\t\t\t\t\t<span class=\"pull-right-container\">";
                    echo "\n\t\t\t\t\t\t\t<i class=\"fa fa-angle-left pull-right\"></i>";
                    echo "\n\t\t\t\t\t\t</span>";
                    echo "\n\t\t\t\t\t</a>";       echo "\n\t\t\t\t\t<ul class=\"treeview-menu\">";
                }

         

                if (strlen($row->script) > 1) {
                    echo "\n\t\t\t\t\t\t<li>\n\t\t\t\t\t\t\t<a href='" . base_url() . "admin/" . $row->script . "'><i class=\"" . $row->cssClass . "\"></i> " . $row->section . "</a>\n\t\t\t\t\t\t</li>";
                }
                $topSection = $row->topSection;

            endforeach;
            ?>  

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
