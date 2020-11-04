function showTable() {
  document.write(
    '<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">'
  );
  document.write("<thead><tr>");

  var title = [
    "日付",
    "曜日",
    "区分",
    "始業時刻",
    "終業時刻",
    "休憩時間",
    "時間内時間",
    "時間外時間",
    "休日時間",
    "事務内容",
    "勤怠" //,
    // "edit",
    // "delete"
  ];

  for (i in title) {
    // tieu de cua bang
    document.write("<th>" + title[i] + "</th>");
  }
  // Hang doc cua bang
  document.write("</tr></thead>");
  document.write("<tbody>");
  testDay();
  //   document.write("<tr>");
  //   document.write("<td> 1 </td>");
  //   document.write(" <td> Funda of WEb IT</td>");
  //   document.write("<td> Funda of WEb IT</td>");
  //   document.write("<td> funda@example.com</td>");
  //   document.write("<td> *** </td>");
  //   document.write("<td> *** </td>");
  //   document.write("<td> *** </td>");
  //   document.write("<td> *** </td>");
  //   document.write("<td> *** </td>");
  //   document.write(
  //     '<td><form action="" method="post"><input type="hidden" name="edit_id" value=""><button  type="submit" name="edit_btn" class="btn btn-success"> EDIT</button></form></td>'
  //   );
  //   document.write(
  //     '<td><form action="" method="post"><input type="hidden" name="delete_id" value=""><button type="submit" name="delete_btn" class="btn btn-danger"> DELETE</button></form></td>'
  //   );
  //   document.write("</tr>");
  document.write("</tbody>");
  document.write("</table>");
}

function testDay() {
  var days = ["日", "月", "火", "水", "木", "金", "土"];
  var d = new Date();

  // thay doi nam hien thi
  //d.setFullYear(2020);
  var a = 2;
  var c = 2018;
  d.setMonth(a);
  d.setFullYear(c);
  var b = d.getMonth() + 1;

  for (j = 1; j <= testfor(b, c); j++) {
    //thay doi thang hien thi
    d.setFullYear(c);
    d.setMonth(a);
    d.setDate(j + 20);
    var b1 = d.getMonth() + 1;
    var e = d.getDate();
    //check thang 12 trong nam
    result = days[d.getDay(e)];
    result2 = d.getFullYear() + "/" + b1 + "/" + e;
    document.write("<tr>");
    // hang ngang cua bang
    for (k = 0; k < 1; k++) {
      document.write("<td>" + result2 + "</td>");
      document.write("<td>" + result + "</td>");
      document.write("<td></td>");
      document.write("<td></td>");
      document.write("<td></td>");
      document.write("<td></td>");
      document.write("<td></td>");
      document.write("<td></td>");
      document.write("<td></td>");
      document.write("<td></td>");
      document.write("<td></td>");
      // document.write(
      //   '<td><form action="" method="post"><input type="hidden" name="edit_id" value=""><button  type="submit" name="edit_btn" class="btn btn-success"> EDIT</button></form></td>'
      // );
      // document.write(
      //   '<td><form action="" method="post"><input type="hidden" name="delete_id" value=""><button type="submit" name="delete_btn" class="btn btn-danger"> DELETE</button></form></td>'
      // );
    }
    document.write("</tr>");
  }
}
function testfor(n, b) {
  var result = null;
  if (n == 4 || n == 6 || n == 9 || n == 11) {
    result = 30;
  } else if (n == 2) {
    if (b % 4 == 0) {
      result = 29;
    } else result = 28;
  } else {
    result = 31;
  }
  return result;
}
