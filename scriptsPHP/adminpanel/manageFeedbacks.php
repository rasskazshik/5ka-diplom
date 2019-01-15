<div class="commentTitle container">
    <h3>Управление отзывами</h3>
    <form class="searchForm">
        <p>Имя владельца отзыва:</p>
        <input class='adminpanelSearch searchName' placeholder="Любое имя" list="usersNames">
        <datalist id="usersNames">
<?php
$usersNames=DatabaseAPI::GetAllUsersNames();
if($usersNames->num_rows>0){
while($userName=mysqli_fetch_assoc($usersNames)){
    $id=$userName["id"];
    $name=$userName['name'];
    $lastname=$userName['lastname']; 
print<<<END
<option userId="$id" value="$name $lastname (id: $id)">
END;
    }
}
?>
        </datalist>
    
        <p>Адрес торговой точки:</p>
        <input class='adminpanelSearch searchAddress' placeholder="Любой адрес" list="marketAddresses">
        <datalist id="marketAddresses">
<?php
$marketsAddresses=DatabaseAPI::GetAllMarketsAddresses();
if($marketsAddresses->num_rows>0){
while($marketAddress=mysqli_fetch_assoc($marketsAddresses)){
    $id=$marketAddress["id"];
    $address=$marketAddress["address"]; 
print<<<END
<option marketId="$id" value="$address">
END;
    }
}
?>
        </datalist>
        <input class='adminpanelSearchButton' type="button" value="Найти">
    </form>
</div>
<div class="searchContainer">
<?php
require_once '../scriptsPHP/mysqlDatabaseAPI/databaseAPI.php';
?>
</div>