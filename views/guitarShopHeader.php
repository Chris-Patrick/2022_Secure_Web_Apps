<!DOCTYPE html>
<html>
<head>
    <title><?php echo Page::$title; ?></title>
    <link rel="stylesheet" type="text/css" href="content/css/main.css">
</head>

<body>
    <header>
        <h1>guitarShop</h1>
    </header>
    <aside>
    <h2></h2>
    <nav>
    <ul>
        <li>
            <a href=".">Home</a>
        </li>
        <li>
            <a href="?ctlr=admin&amp;action=login">Log In</a>
        </li>
    </ul>
    <h2>Shop Categories</h2>
    <ul>
        <!-- display links for all categories -->
        <?php foreach ($vm->categories as $category) { ?>
        <li>
            <a href="?ctlr=home&amp;action=listProducts&amp;categoryId=<?php echo $category->id; ?>">
                <?php echo $category->name; ?>
            </a>
        </li>
        <?php } ?>
        <li>&nbsp;</li>
    </ul>
    </nav>
    </aside>
