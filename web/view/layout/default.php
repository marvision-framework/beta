<html>
<head>
	<title><?= (!empty($title_for_layout)) ? $title_for_layout  : SiteName ; ?></title>
</head>
<body>
<?= $this->Session->flash(); ?>
<?= $content_for_layout; ?>
</body>
</html>