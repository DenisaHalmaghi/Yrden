<?php

    if(!mysql_num_rows($data['addresses']))
    {
        echo " <p class='ta-c'>You don't have any saved shipping addresses</p>";
        return;
    }
    while ($row=mysql_fetch_array($data['addresses']))
    {
        $address=$viewUtil->buildAddressString($row);
        $addressID=$row['ID'];    
        
        echo "
        <div class='borderBottom order centeredRow'>
            <p class='address'>$address</p>
            <form method='POST' action='./?url=user/deleteAddress'>
                <input name='addressID' value='$addressID' hidden>
                <button type='submit' class='btn btn-primary btn--small'><i class='fas fa-trash'></i></button>
            </form>
        </div>
        ";
    }