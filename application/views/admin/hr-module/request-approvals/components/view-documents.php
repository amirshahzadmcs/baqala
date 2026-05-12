<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Documents</title>
	<!-- Bootstrap Css -->
	<link href="<?php echo base_url('admin_assets/css/bootstrap.min.css'); ?>" id="bootstrap-style" rel="stylesheet" type="text/css" />
	<style> 
		ul li{
			list-style: auto;
		}
	</style>
</head>
<body>

<h3>All Documents</h3>

<?php if (!empty($documents)): ?>
    <ul>
        <?php foreach ($documents as $document): ?>
            <li>
                <!-- Display document link or preview -->
                <?php 
                $filePath = base_url(ltrim($document, './'));
                $fileExt = pathinfo($filePath, PATHINFO_EXTENSION);
                
                // If it's an image or PDF, try to display it
                if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'pdf'])) {
                    echo "<a href=\"$filePath\" target=\"_blank\" class='btn btn-primary btn-sm'>View File</a>";
                } else {
                    echo "<a href=\"$filePath\" target=\"_blank\" class='btn btn-primary btn-sm'>View File</a>";
                }
                ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No documents found.</p>
<?php endif; ?>

</body>
</html>
