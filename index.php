<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="robots" content="noindex, nofollow" />
		<meta name="googlebot" content="noindex, nofollow, noarchive, noodp, nosnippet, noimageindex" />
		<meta name="human" content="NO PEEKING!!!!!!!!!!!" />
		<title>My WordPress Snippets</title>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.css">
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.css">
	</head>
<body>
<div class="container">
	<h1><i class="fa fa-download"></i> WP Snippets</h1>

				<?php
					// function to get file size
					// usage echo formatbytes("$_SERVER[DOCUMENT_ROOT]/images/large_picture.jpg", "MB");
					// MB can be subtitute with KB or GB
					function human_filesize($file, $decimals = 2) {
						$bytes = filesize($file);
						$sz = 'BKMGTP';
						$factor = floor((strlen($bytes) - 1) / 3);
						return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
					}

					function jenis($file) {
						$cek = (is_dir($file));
						if ($cek == 0) { $jenis = 'file'; } else { $jenis = 'directory'; }
						return $jenis;
					}

					$dirFiles = array();
					
					$thelist = '';
					$fcount = 0;
					$target = get_template_directory();
					if ($handle = opendir( $target )) {
						while (false !== ($file = readdir($handle)))
						{
							if ( ($file != ".") && ($file != "..") && ($file != "index.php") && ($file != "css") && ($file != "fonts") && (!is_dir($file)) )
							{
								$dirFiles[] = $file;
								$fcount++;
							}
						}

						closedir($handle);
					}
					?>

		<table class="table table bordered table-striped">
			<tr>
				<th>File Name</th>
			</tr>

			<?php
				sort($dirFiles);
				foreach($dirFiles as $file) {
				
				echo '<tr><td><a href="'.get_template_directory_uri().'/'.$file.'">'.$file.'</a></td>';

				}
			?>
		</table>

		<p class="text-right">Listing <code><?php echo $fcount; ?></code> files+directories</p>

		<hr />
		
	</div>
</body>
</html>