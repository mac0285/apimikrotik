<?php
/*
 *  Copyright (C) 2018  
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
session_start();
?>

<div style="padding-top: 5%;"  class="login-box">
  <div class="card">
    <div class="card-header">
      <h3>Please Login</h3>
    </div>
    <div class="card-body">
      <div class="text-center pd-5">
        <img src="img/favicon.png" alt="SDT LOGO">
      </div>
      <div  class="text-center">
      <span style="font-size: 25px; margin: 10px;">LOGIN USER</span>
      </div>
      <form autocomplete="off" action="" method="post">
      <table class="table">
        <tr>
          <td class="align-middle text-center">
            <input class="form-control" type="text" name="user" placeholder="synergy" required="1" autofocus>
          </td>
        </tr>
        <tr>
          <td class="align-middle text-center">
            <input class="form-control" type="password" name="pass" placeholder="xcxc" required="1">
          </td>
        </tr>
        <tr>
          <td class="align-middle text-center">
            <input style="cursor:pointer; width: 100%; height: 35px; font-weight: bold; font-size: 17px;" class="btn-login bg-primary" type="submit" name="login" value="Login">
          </td>
        </tr>
        <tr>
          <td class="align-middle text-center">
            <?php echo $error; ?>
          </td>
        </tr>
      </table>
      </form>
    
    </div>
  </div>
</div>
</body>
</html>