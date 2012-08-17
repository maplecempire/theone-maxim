<?php
require_once("../inc.config.php");
require_once(M_ROOT."/functions/compression/compression_function.php");
output_compressed_file(StripSlashes($_GET["file"]));
?>