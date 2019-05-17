<html>
    <head>
        <style>
            @page {
                margin: 0px 0px;
            }
            header {
                position: fixed;
                top: 0px;
                left: 0px;
                right: 0px;
                height: 50px;
                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 35px;
            }
            footer {
                position: fixed; 
                bottom: 0px; 
                left: 0px; 
                right: 0px;
                height: 50px; 
                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 35px;
            }
            body{
                margin-top: 2cm;
                margin-left: 2cm;
                margin-right: 2cm;
                margin-bottom: 2cm;
            }
        </style>
    </head>
    <body>
        <header>            
            <img src= "<?= base_url() ?>/assets/app/users/avatar/avatar_1.jpg" height="60"/>
            Our Code World
        </header>

        <footer>
            Copyright &copy; <?php echo date("Y"); ?>  Page 
            <script type="text/php">
                    $this->get_canvas()->page_script('
                        $font = $fontMetrics->getFont("Arial", "bold");
                        $this->get_canvas()->text(770, 580, "Page $PAGE_NUM of $PAGE_COUNT", $font, 10, array(0, 0, 0));
                    ');                
            </script>
        </footer>
        
        <main>            
           <?php 
                for($i=0;$i<=100;$i++){
                    echo "Ini Kontent ke $i";
                    echo "<br>";
                }
           ?>
        </main>
    </body>
</html>