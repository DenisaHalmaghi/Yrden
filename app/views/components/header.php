<nav class="navBar centeredRow">
  <a href="./" class="navBar__logoWrapper navBar__logo centeredRow">
    <img src="<?php echo ASSET_URL . 'images/logo.png' ?>" alt="logo">
    <span class="brandName">Yrden</span>
  </a>

  <div class="centeredRow">
    <div class="centeredRow" id="hamburger">
      <input type="checkbox" />
      <div class="hamburger">
        <span></span>
        <span></span>
        <span></span>
      </div>

      <ul id="menu" class="navBar__list centeredRow">
        <?php
        $links = array(
          (object) array('href' => './', 'text' => 'Home'),
          (object) array('href' => './?url=home/products/', 'text' => 'Products')

        );

        function appendLink($carry, $link)
        {
          $carry .= "<li class='navBar__list-item'><a href='{$link->href}'>{$link->text}</a></li>";
          return $carry;
        }

        $listElements = array_reduce($links, "appendLink");
        echo $listElements;

        if (!isset($_SESSION['ID'])) {
          echo " <li class='navBar__list-item'> <a href='./?url=home/signup'>SignUp</a></li> <li class='navBar__separator'>|</li><li class='navBar__list-item'>  <a href='./?url=home/login'>LogIn</a></li>";
        } else {
          if ($_SESSION['Type'] == "admin") {
            $link = " <li class='navBar__list-item'><a href='./?url=admin/getProducts'><i class='fas fa-database'></i> </a></li>";
          }
          echo " 
                            $link
                            <li class='navBar__list-item'><a href='./?url=user/'><i class='far fa-user'></i> </a></li>
                            <li class='navBar__list-item'><a href='./?url=user/logout'> LogOut</a></li>
                        ";
        }

        ?>

      </ul>

    </div>



    <div class="centeredRow">
      <div class="cart">
        <svg class="cart__icon">
          <use xlink:href="#icon-basket">
            <svg viewBox="0 0 23 23" id="icon-basket">
              <g fill="none" fill-rule="evenodd" transform="translate(.083 .083)">
                <path fill="white"
                      d="M21.511 9.055c-.01.052-.057.104-.098.136a3.2 3.2 0 0 1-1.423.652c-.393.073-.787.081-1.184.087-.633.007-1.265.012-1.897.024-.165.002-.33.031-.494.039-.063.002-.127-.02-.19-.033-.123-.026-.246-.08-.369-.075-.29.012-.58.05-.87.084-.285.032-.569.074-.856.05a1.09 1.09 0 0 0-.39.033c-.098.028-.209.006-.313 0l-.02-.002a.158.158 0 0 0-.152-.038 8.92 8.92 0 0 0-.162.041c-.078-.044-.167-.037-.263-.034-.252.005-.504-.03-.756-.043-.396-.02-.792-.035-1.187-.05-.023-.002-.047-.007-.066 0-.269.097-.533-.007-.799-.028-.411-.03-.82-.082-1.232-.122-.048-.005-.098.008-.147.01-.047.003-.094 0-.142.003l-.191.01c-.035.004-.07.018-.105.013-.08-.012-.158-.033-.245-.053-.124-.206-.047-.475-.109-.715-.119-.459-.047-.921-.022-1.383.007-.145.025-.29.04-.434a.234.234 0 0 1-.061-.03c.072-.314.144-.625.177-.946.004-.003.007-.008.012-.011.016-.148.039-.293.068-.438.127-.597.395-1.123.635-1.666.02-.043.043-.085.06-.132.149-.433.415-.766.717-1.07.283-.284.563-.573.848-.855a.876.876 0 0 1 .217-.164c.361-.18.723-.36 1.112-.456.111-.027.227-.043.341-.047.362-.011.714.043 1.043.22.084.045.167.095.24.158.208.174.415.35.61.537.1.094.194.205.265.328.306.521.588 1.057.762 1.659.11.382.248.752.373 1.129.017.045.034.092.046.138.074.293-.075.532-.343.533-.203.001-.407-.025-.61-.038a24.043 24.043 0 0 0-.394-.022c-.075-.003-.159.045-.222-.025-.356.037-1.415-.045-2.484-.06a.19.19 0 0 1-.077.012c-.03-.003-.06-.009-.092-.014-1.317-.008-2.598.099-2.537.668v.02c.173.002.347.024.522.053.094.015.138.077.145.147.167.022.335.043.502.06.79.001 1.582.002 2.372.006.446.003.89.019 1.337.023.455.003.912.007 1.369-.004.276-.006.546.03.816.083.344.067.688.137 1.04.148a.153.153 0 0 0 .072.029c.285.041.568.088.851.134a.198.198 0 0 0 .062.001.645.645 0 0 0 .146.025c.23.019.46.041.69.068.069.01.136.056.205.06.271.017.515.156.778.207.114.022.228.04.34.071.078.022.154.061.229.094.062.027.121.06.184.082l.74.244a.14.14 0 0 0 .121.134c.29.063.436.261.45.51-.01.075-.02.15-.035.225m-.305 1.969c-.088.412-.298.758-.443 1.138l-.068.173a.14.14 0 0 0-.103.084c-.082.176-.14.36-.222.534-.083.137-.159.272-.218.405-.272.596-.501 1.214-.715 1.835-.187.44-.39.878-.478 1.345-.19.393-.296.808-.357 1.237-.2.71-.364 1.452-.41 2.181-.036.175-.066.35-.087.527-.082.322-.211.626-.439.866-.156.165-.345.28-.552.367l-.139.028c-.421.086-.847.142-1.275.182-.196.018-.39.08-.586.095-.504.034-1.004.144-1.511.1-.087-.008-.175-.014-.257.046-.025.02-.073.007-.11 0a1.773 1.773 0 0 0-.687-.03c-.091.014-.186-.016-.279-.02-.418-.012-.836-.017-1.254-.034-.335-.013-.669-.051-1.003-.062-.706-.024-1.399-.166-2.096-.273-.218-.033-.435-.077-.654-.099-.35-.033-.663-.22-.999-.315-.277-.077-.552-.16-.828-.243-.038-.01-.073-.029-.108-.047-.226-.11-.458-.213-.678-.34a.484.484 0 0 1-.176-.237 6.036 6.036 0 0 1-.189-.605c-.093-.358-.17-.72-.268-1.077-.199-.723-.38-1.45-.547-2.182a2.912 2.912 0 0 0-.127-.41 1.571 1.571 0 0 1-.114-.53.48.48 0 0 0-.015-.112c-.062-.23-.128-.457-.187-.687-.198-.764-.501-1.48-.76-2.218-.229-.658-.585-1.23-.85-1.861-.062-.147-.11-.302-.169-.462a.73.73 0 0 1 .48-.072c.76.132 1.524.253 2.285.375.072.012.143.016.215.017.576.014 1.153.042 1.73.03.317-.007.62.068.927.118.43.07.861.126 1.292.192.25.038.5.062.754.073.516.022 1.037.036 1.545.126.862.152 1.724.093 2.586.099.473.003.946-.012 1.418-.037.605-.033 1.208-.081 1.813-.123.5-.034.999-.067 1.497-.105.565-.043 1.129-.119 1.694-.13.439-.007.844-.148 1.256-.28.09-.03.18-.053.274-.013.174.073.236.226.192.431M1.36 8.645c.242-.171.47-.364.704-.548.062-.049.116-.11.207-.058.027.016.08-.021.12-.04.239-.11.472-.24.716-.328.392-.142.776-.317 1.187-.383.44-.07.883-.133 1.325-.197.228-.032.458-.061.686-.094a.38.38 0 0 1 .3.075c.047.036.105.056.18.093a.534.534 0 0 1-.026.422c-.074.156-.079.316-.067.485.007.09-.008.183-.021.273-.023.158-.051.316-.078.473a2.559 2.559 0 0 1-.236.69c-.066.137-.164.214-.303.223-.202.01-.405.023-.609.027a35.72 35.72 0 0 1-1.021.008c-.171 0-.34-.02-.51-.033-.275-.023-.549-.053-.823-.069a4.029 4.029 0 0 1-.96-.157c-.187-.055-.374-.1-.563-.146-.161-.04-.256-.16-.314-.324-.046-.128 0-.317.106-.392m21.478-.298c-.096-.171-.175-.349-.313-.483a1.845 1.845 0 0 1-.232-.269.763.763 0 0 0-.37-.303c-.395-.137-.787-.284-1.188-.39-.255-.07-.52-.094-.759-.234-.039-.023-.083-.034-.127-.045a7.971 7.971 0 0 0-1.367-.244 12.124 12.124 0 0 1-.74-.073c-.586-.081-1.052-.393-1.352-.991a8.359 8.359 0 0 1-.385-.858c-.168-.454-.31-.921-.463-1.382-.24-.73-.577-1.393-1.058-1.95-.206-.239-.422-.467-.694-.603-.176-.087-.348-.19-.523-.274-.184-.089-.389-.122-.586-.175-.075-.02-.153-.018-.229-.033a1.82 1.82 0 0 0-.994.068c-.09.032-.181.072-.272.074-.143.002-.268.06-.397.115l-.156.063c-.36.143-.703.327-.997.613-.625.606-1.215 1.251-1.607 2.094-.153.327-.36.62-.466.98-.121.413-.27.815-.403 1.224-.028.088-.041.184-.064.275a.424.424 0 0 1-.04.118c-.047.082-.1.162-.164.265a12.28 12.28 0 0 0-2.204.23c-.229.046-.476.029-.672.218-.007.006-.02.006-.031.007-.33.036-.632.204-.952.29-.582.156-1.158.35-1.668.74C.953 7.732.548 8.058.2 8.468a.838.838 0 0 0-.193.468c-.031.26.056.5.055.752 0 .018.012.035.02.051.208.41.393.834.646 1.211a.731.731 0 0 1 .087.16c.163.438.374.846.592 1.25.257.48.478.981.668 1.501.393 1.08.655 2.202.854 3.345.108.628.212 1.255.332 1.878.098.502.243.987.465 1.436.075.151.158.29.252.419.064.122.143.237.231.346.443.751 1.56.969 2.488 1.096a.175.175 0 0 0 .107.053c.649.071 1.29.138 1.926.291.04.01.076.005.106-.009.536.095 1.077.165 1.62.21 1.09.088 2.18.068 3.267.005.615-.037 1.23-.08 1.845-.132a57.19 57.19 0 0 0 1.923-.195 2.983 2.983 0 0 0 1.06-.337c.277-.149.516-.348.706-.609a.163.163 0 0 0 .057-.063l.04-.082c.022-.04.046-.078.067-.12.036-.069.077-.154.07-.226-.01-.104.021-.182.053-.268.045-.13.098-.257.124-.392.084-.424.162-.852.23-1.28.121-.766.218-1.536.35-2.299.269-1.543.74-3.005 1.337-4.417.206-.49.43-.967.705-1.412.133-.217.242-.453.36-.683.178-.35.246-.747.306-1.135.049-.31.05-.637-.118-.934"
                      mask="url(#basket-b)"></path>
              </g>
            </svg>
          </use>
        </svg>
        <span class="cart__number"><?php echo $_SESSION['itemsInCart']; ?></span>
        <div class="cart__contents ">

          <?php
          $viewUtil = new Util_View;
          $cartItems = "";

          if ($_SESSION['itemsInCart']) {
            foreach ($_SESSION['cart'] as $id => $item) {
              $itemImg = PRODUCTS_URL . $item['image'];
              $itemName = $item['name'];
              $itemPrice = $item['Price'];
              $itemQty = $item['Qty'];

              $cartItems .= "<div class='cart__item row'>
                        <a href='./?url=home/product/$id'><img width='100' src='$itemImg' alt='$itemName'></a>
                        
                        <div class='cart__item__info'>
                            <p>$itemName</p>
                            <p class='cart__item__price'>$$itemPrice x $itemQty</p>
                        </div>
                        </div>";
            }
          } else {
            $cartItems = "<p class='ta-c c-prm bold uppercase  mt-1'>No items in cart</p>";
          }


          echo $cartItems; ?>
          <div class="row j-s-e">
            <a href="./?url=home/cart" class='btn btn-primary btn--small w-5'>cart</a>
            <a href="./?url=user/checkout" class='btn btn-primary btn--small w-5'>Checkout</a>
          </div>

        </div>
      </div>

    </div>
  </div>

</nav>
