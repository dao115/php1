   <div class="container">





       <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
           <div class="container">

               <div class="navbar-header">
                   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                       <span class="sr-only">Toggle navigation</span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                       <span class="icon-bar"></span>
                   </button>
                   <a class="navbar-brand" href="index.php">Home</a>
               </div>

               <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                   <ul class="nav navbar-nav">

                       <li>
                           <a href="shop.php">Shop</a>
                       </li>
                       <li>
                           <a href="checkout.php">Checkout</a>
                       </li>
                       <li>
                           <a href="contact.php">Contact</a>
                       </li>
                       <li>
                           <a href="login.php">Login</a>
                       </li>









                   </ul>
                   <ul class="nav navbar-right top-nav">
                       <li class="dropdown">

                           <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>

                               <?php

                                if (isset($_SESSION['username'])) {
                                    echo $_SESSION['username'];
                                } else {

                                    echo "unregistered user";
                                }



                                ?>

                               <b class="caret"></b></a>


                           <ul class="dropdown-menu">

                               <li class="divider"></li>
                               <li>
                                   <a href="./logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                               </li>
                               <li>
                                   <a href="resetpassword.php">Change Password</a>
                               </li>
                               <li>
                                   <a href="updateuser.php">Cap nhat tai khoan</a>
                               </li>

                           </ul>
                       </li>




                   </ul>





               </div>


       </nav>






   </div>