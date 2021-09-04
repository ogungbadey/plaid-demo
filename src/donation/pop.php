<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    
</head>
<body class="is-boxed has-animations">
    

    <center>

    <h1>Get dropdown value</h1>
    <h2></h2>
    <hr/>

    <form method="POST">
    <select name="Cars">
        <option value="ford">Ford</option>
        <option value="BMW">BMW</option>
        <option value="BenZ">Benz</option>
    </select>
    <input type="submit" name="submit" value="Get selected car" />
    </form>

    <?php
        if (isset($_POST['submit'])){
            $getcar = $_POST['Cars'];
            echo 'The Selected Car : ' . $getcar;
        }
    ?>

    </center>
    
</body>
</html>
