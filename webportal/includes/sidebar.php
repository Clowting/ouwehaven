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

                <?php if (isPenningmeester($roles)) { ?>
                <li class="sidebarSub"><i class="fa fa-btc"></i> Penningmeester
                    <ul>
                        <li>
                            <a href="transactions.php"><i class="fa fa-file-text"></i> Transacties</a>
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
            </ul>
        </div>