<!DOCTYPE html>
<html lang="en">
<head>
  <title>BOwners</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<style>
content {

	padding:20px !important;
}
.maintable{

	padding:20px;
	padding-right:20px !important;
}
.right{
	float: right;
}

table,tr,td {

  background-color: white !important;
}

</style>
<body>
<br><Br>

<div class="container maintable">


     <div class="table-responsive  " style="overflow-x:auto; ">
                <table class="table table-bordered table-hover ">
                    <thead>
                         <tr>
                            <th width="80px" class="hidden-xs">Id</th>
                            <th width="180px">Contact</th>
                            <th width="180px">Cell</th>
                            <th width="180px">Email</th>


                         </tr>
                     </thead>
                     <tbody>
                     @foreach ($owners as $owner)
                        <tr>
                            <td class="hidden-xs">
                                  {{ $owner->id }}
                            </td>
                            <td>
                                {{  $owner->contact }}

                            </td>
                            <td>
                                {{ $owner->cell}}
                            </td>
                            <td>
                                 {{ $owner->email}}
                            </td>

                        </tr>
                        @endforeach
                     </tbody>
                     </table>
                        </div>
            </div>
            <div class="right">
            {{$owners->links()}}
            </div>
            </div>
</body>
