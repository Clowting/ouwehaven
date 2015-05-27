        <div id="sidebar-wrapper">
            <a class="btn btn-default" id="menu-toggle">
                <i class="fa fa-lg fa-angle-left"></i>
            </a>
            
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        De 'n Ouwe Haven
                    </a>
                </li>
                <li>
                    <a href="/webportal">Dashboard</a>
                </li>
                <li>
                    <a href="ships.php"><i class="fa fa-ship"></i> Schepen</a>
                </li>
                <li>
                    <a href="reservations-request.php"><i class="fa fa-clock-o"></i> Reserveren</a>
                </li>
                <li>
                    <a href="settings.php"><i class="fa fa-cog"></i> Instellingen</a>
                </li>

                <?php if (isHavenmeester($roles)) { ?>
                <li class="sidebarSub"><i class="fa fa-list-ul"></i> Havenmeester
                    <ul>
                        <li>
                            <a href="reservations.php"><i class="fa fa-clock-o"></i> Reserveringen</a>
                        </li>
                    </ul>
                </li>

                <?php } if (isPenningmeester($roles)) { ?>
                <li class="sidebarSub"><i class="fa fa-btc"></i> Penningmeester
                    <ul>
                        <li>
                            <a href="transactions.php"><i class="fa fa-file-text"></i> Transacties</a>
                        </li>
                        <li>
                            <a href="categories.php"><i class="fa fa-list"></i> Rubrieken</a>
                        </li>
                        <li>
                            <a href="balances.php"><i class="fa fa-euro"></i> Saldi</a>
                        </li>
                        <li>
                            <a href="financial-year.php"><i class="fa fa-bar-chart"></i> Financieel jaarverslag</a>
                        </li>
                        <li>
                            <a href="cashbook.php"><i class="fa fa-money"></i> Kasboek</a>
                        </li>
                    </ul>
                </li>

                <?php } if (isAdmin($roles)) { ?>
                <li class="sidebarSub"><i class="fa fa-gear"></i> Administrator
                    <ul>
                        <!-- Admin pagina's komen hier. -->
                    </ul>
                </li>
                <?php } ?>
                
                <li>
                    <a href="<?php echo wp_logout_url( get_permalink() ); ?>"><i class="fa fa-eject"></i> Uitloggen</a>
                </li>
            </ul>
        </div>