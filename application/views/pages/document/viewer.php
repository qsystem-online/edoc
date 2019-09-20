<html>
    <head>
        <!-- jQuery 3 -->
        <script src="{base_url}bower_components/jquery/dist/jquery.min.js"></script>
        <script src="<?=base_url()?>bower_components/pdfjs/build/pdf.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?=base_url()?>bower_components/bootstrap/dist/css/bootstrap.min.css">
        <script src="<?=base_url()?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- Font Awesome -->
		<link rel="stylesheet" href="<?=base_url()?>bower_components/font-awesome/css/font-awesome.min.css">

        <style>
            #the-canvas{
                -webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
                -moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
                box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);
                border:1px solid #999;
            }
        </style>
    </head>
    <body>
        <div id="canvas-container" style="text-align:center;margin-top:20px">
            <div style="margin-bottom:10px">
                <button id="btnDocFirst" class="btn btn-primary btn-sm doc-view-tool"> <i class="fa fa-fast-backward" aria-hidden="true"></i> First</button>
                <button id="btnDocPrev" class="btn btn-primary btn-sm doc-view-tool"> <i class="fa fa-step-backward" aria-hidden="true"></i> Prev</button>
                <button id="btnDocNext" class="btn btn-primary btn-sm doc-view-tool"> Next <i class="fa fa-step-forward" aria-hidden="true"></i> </button>
                <button id="btnDocLast" class="btn btn-primary btn-sm doc-view-tool">Last <i class="fa fa-fast-forward" aria-hidden="true"></i> </button>
                <button id="btnZoomIn" class="btn btn-primary btn-sm doc-view-tool"><i class="fa fa-search-plus" aria-hidden="true"></i> In </button>
                <button id="btnZoomOut" class="btn btn-primary btn-sm doc-view-tool"><i class="fa fa-search-minus" aria-hidden="true"></i> Out </button>
                <?php if ($printDoc){ ?>
                    <button id="btnDocDownload" class="btn btn-primary btn-sm doc-print-tool"><i class="fa fa-download" aria-hidden="true"></i> Download </button>
                <?php } ?>
            </div>
            <div id="pageInfo"> <b>Pages: 1 / 1</b></div>
            <canvas id="the-canvas"></canvas>
        </div>

        <script type="text/javascript"> //Document Viewer
            var docPdf = null;
            var curPage = 1;
            var scale_required = 1;

            function showDocument(fblView,fblPrint,token){
                
                var url = "{base_url}document/getDocument/" + token;
                //var pdfjsLib = window['pdfjs-dist/build/pdf'];
                var pdfjsLib = window['pdfjs-dist/build/pdf'];
                console.log(pdfjsLib);
                pdfjsLib.GlobalWorkerOptions.workerSrc = '{base_url}bower_components/pdfjs/build/pdf.worker.js';
                //pdfjsLib.GlobalWorkerOptions.workerSrc = '//mozilla.github.io/pdf.js/build/pdf.worker.js';

                var loadingTask = pdfjsLib.getDocument(url);
                loadingTask.promise.then(function(pdf) {
                    docPdf = pdf;
                    curPage = 1;
                    renderPage(1);			

                }, function (reason) {
                    // PDF loading error
                    console.error(reason);
                });
            }

            function nextDoc(){		
                if (curPage >= docPdf.numPages) {
                    return;
                }
                curPage++
                renderPage(curPage);
            }

            function prevDoc(){		
                if (curPage <= 1) {
                    return;
                }
                curPage--;
                renderPage(curPage);
            }

            function firstDoc(){
                curPage = 1;
                renderPage(curPage);
            }
            function lastDoc(){
                curPage = docPdf.numPages;
                renderPage(curPage);
            }


            function renderPage(pageNumber) {
                // Fetch the first page
                //var pageNumber = 1;
                docPdf.getPage(pageNumber).then(function(page) {
                    // Prepare canvas using PDF page dimensions
                    var canvas = $('#the-canvas').get(0); // document.getElementById('the-canvas');
                    var context = canvas.getContext('2d');

                    // As the canvas is of a fixed width we need to set the scale of the viewport accordingly
                    //var scale_required = canvas.width / page.getViewport(1).width;
                    //var scale_required =2;
                    var viewport = page.getViewport(scale_required);

                    canvas.width = viewport.width;
                    canvas.height = viewport.height;
                    

                    // Render PDF page into canvas context
                    var renderContext = {
                        canvasContext: context,
                        viewport: viewport
                    };
                    var renderTask = page.render(renderContext);
                    renderTask.promise.then(function () {
                        console.log('Page rendered');
                        //$("#the-canvas").show();
                    });
                });
                $("#pageInfo").html("<b>Pages : " + curPage + "/" + docPdf.numPages + "</b>");
                console.log(curPage);
            }

            function zoomIn(){
                if (scale_required >= 2.5){
                    return;
                }
                scale_required = scale_required + 0.25;
                renderPage(curPage);
            }

            function zoomOut(){
                if (scale_required <= 0.25){
                    return;
                }
                scale_required = scale_required - 0.25;
                renderPage(curPage);
            }

            $(function(){     

                var canvas = document.getElementById("the-canvas");
                var ctx = canvas.getContext("2d");
                var text = "Document loading, Please waittt ...!";

                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = "#0033DD";
                ctx.font = "italic bold 14px Arial";
                ctx.fillText(text, 20, canvas.height/2);



                showDocument(true,false,"{viewToken}");

                $("#btnDocFirst").click(function(event){
                    event.preventDefault();
                    firstDoc();
                });
                $("#btnDocPrev").click(function(event){
                    event.preventDefault();
                    prevDoc();
                });
                $("#btnDocNext").click(function(event){
                    event.preventDefault();
                    nextDoc();
                });
                $("#btnDocLast").click(function(event){
                    event.preventDefault();
                    lastDoc();
                });
                $("#btnZoomIn").click(function(event){
                    event.preventDefault();
                    zoomIn();
                });
                $("#btnZoomOut").click(function(event){
                    event.preventDefault();
                    zoomOut();
                });
                
                $("#btnDocDownload").click(function(event){
                    event.preventDefault();
                    window.location.replace("{base_url}document/downloadDocument/{fin_document_id}");
                });            
            });

        </script>

    </body>
</html>