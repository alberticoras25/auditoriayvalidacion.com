<?php
    $titulo = utf8_convert($doc["titulo"]);
    $txt = html_entity_decode($doc["txt"]);
    $url = $doc["url"];
    if($url != "")
        $myFile = '<iframe src="mydocument.php?id='.$_SESSION["idDocAct"].'" style="width:100%; height:600px;" frameborder="0"></iframe>';
?>

    <section class="why-choose-area why-choose-about pt-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-9">
                    <div class="why-choose-content">
                        <div class="content">
                            <h3 class="title"><?=$titulo;?></h3>
                            <div class="ql-editor"><?=$txt;?></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6"><?=$myFile;?></div>
            </div>
        </div>
    </section>