<?php
    session_start();
    if(!isset($_SESSION['login'])) {
        header('LOCATION:home.php');
        die();
    }
    include_once("Scripts/config.php");
    include_once("Scripts/selectReservation.php");
    $result = mysqli_query($mysqli, "select reservation.reservation_id,rooms.room_number,users.name,reservation.check_in_date,reservation.check_oute_date
                                     from reservation
                                     inner join users on reservation.user_id = users.user_id
                                     inner join rooms on reservation.room_id = rooms.room_id;");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="jquery-3.3.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/postboot.min.css"/>
    <link rel="stylesheet" href="css/style.css"/>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/postboot.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.11/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.11/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <title></title>


  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a id=sitename class="navbar-brand" href="home.php">Empire Hotel</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="reservations.php">Reservations <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="rooms.php">Rooms</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="users.php">Users</a>
          </li>
        </ul>
        <form action="Scripts/logout.php" method="POST">
          <button type="submit" class="btn btn-outline-danger my-2 my-sm-0" name="logout">Logout</button>
        </form>
      </div>
    </nav>

    <div class="btn-toolbar">
        <button id=addButton class="btn btn-outline-success my-2 my-sm-0" data-toggle="modal" data-target="#addModal" type="button">Add a Reservation</button>
        <button id=deleteButton class="btn btn-outline-primary my-2 my-sm-0" data-toggle="modal" data-target="#selectModal" type="button">Update a Reservation</button>
        <button id=updateButton class="btn btn-outline-danger my-2 my-sm-0" data-toggle="modal" data-target="#deleteModal" type="button">Delete a Reservation</button>
    </div>
    <div id="tableDiv">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">User</th>
            <th scope="col">Room</th>
            <th scope="col">Check In</th>
            <th scope="col">Check Out</th
          </tr>
          <?php
            while ($res=mysqli_fetch_array($result))
            {
              $reservation_id = $res['reservation_id'];
              $room_number = $res['room_number'];
              $name = $res['name'];
              $check_in_date = $res['check_in_date'];
              $check_out_date = $res['check_oute_date'];
              echo"<tr>
                    <td>$reservation_id</td>
                    <td>$name</td>
                    <td>$room_number</td>
                    <td>$check_in_date</td>
                    <td>$check_out_date</td>
                  </tr>";
            }

          ?>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
    <div id="addModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <form action="Scripts/addReservation.php" id="addForm" method="post">
            <div class="form-group">
              <label for="exampleFormControlSelect1">Select User ID</label>
              <select name = "user_id"class="form-control" id="exampleFormControlSelect1">
                <?php
                  $resulted = mysqli_query($mysqli, "SELECT user_id FROM users");
                  while ($res=mysqli_fetch_array($resulted))
                  {
                    $userId = $res['user_id'];
                    echo"<option>$userId</option>";
                  }
                ?>
              </select>
              <label for="exampleFormControlSelect1">Select Room ID</label>
              <select type="text" name="room_id" class="form-control" id="exampleFormControlSelect1">
                <?php
                $resulted = mysqli_query($mysqli, "SELECT room_id FROM rooms");
                while ($res=mysqli_fetch_array($resulted))
                {
                  $room_id = $res['room_id'];
                  echo"<option>$room_id</option>";
                }
                ?>
              </select>
                  Check In Date: <input name = "check_in_date" id="startDate1" width="276" />
                  Check Out Date: <input name = "check_out_date" id="endDate1" width="276" />
              <script>
                  var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                  $('#startDate').datepicker({
                      uiLibrary: 'bootstrap4',
                      format: 'yyyy-mm-dd',
                      iconsLibrary: 'fontawesome',
                      minDate: today,
                      maxDate: function () {
                          return $('#endDate').val();
                      }
                  });
                  $('#endDate').datepicker({
                      uiLibrary: 'bootstrap4',
                      format: 'yyyy-mm-dd',
                      iconsLibrary: 'fontawesome',
                      minDate: function () {
                          return $('#startDate').val();
                      }
                  });
              </script>
              <script>
                  var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
                  $('#startDate1').datepicker({
                      uiLibrary: 'bootstrap4',
                      format: 'yyyy-mm-dd',
                      iconsLibrary: 'fontawesome',
                      minDate: today,
                      maxDate: function () {
                          return $('#endDate1').val();
                      }
                  });
                  $('#endDate1').datepicker({
                      uiLibrary: 'bootstrap4',
                      format: 'yyyy-mm-dd',
                      iconsLibrary: 'fontawesome',
                      minDate: function () {
                          return $('#startDate1').val();
                      }
                  });
              </script>

              <br>
              <button id="addButton" type="submit" class="btn btn-success" name="insert" value="insert">Add Reservation</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div id="deleteModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <form id=deleteForm action="Scripts/deleteReservation.php" method='POST'>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Select Reservation to Delete</label>
              <select type="text" name="reservation_id" class="form-control" id="exampleFormControlSelect1">
                <?php
                  $resulted = mysqli_query($mysqli, "SELECT reservation_id FROM reservation");
                  while ($res=mysqli_fetch_array($resulted))
                  {
                    $reservationid = $res['reservation_id'];
                    echo"<option>$reservationid</option>";
                  }
                ?>
              </select>

            </div>
            <button type="submit" class="btn btn-danger" name="delete" value="delete">Delete Reservation</button>
          </form>
        </div>
      </div>
    </div>
    <div id="selectModal" class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <form id=selectForm action="" method='POST'>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Select Reservation to Update</label>
              <select type="text" name="reservation_id" class="form-control" id="exampleFormControlSelect1">
                <?php
                  $resulted = mysqli_query($mysqli, "SELECT reservation_id FROM reservation");
                  while ($res=mysqli_fetch_array($resulted))
                  {
                    $reservationid = $res['reservation_id'];
                    echo"<option>$reservationid</option>";
                  }

              echo"</select>

            </div>
            <button type='submit' class='btn btn-primary' name='select' value='$reservationid' >Select Reservation</button>
          </form>"
          ?>
        </div>
      </div>
    </div>
  </body>
</html>
