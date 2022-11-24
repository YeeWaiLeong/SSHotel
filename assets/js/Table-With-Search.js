//Table with search
$(document).ready(function() {
  $("#search1").keyup(function () {
    var searchTerm = $("#search1").val();
    //var listItem = $('.results tbody[name="first"]').children('tr');
    var searchSplit = searchTerm.replace(/ /g, "'):containsi('")
    
  $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
        return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }
  });
    
  $(".results tbody[name='first'] tr").not(":containsi('" + searchSplit + "')").each(function(e){
    $(this).attr('visible','false');
  });

  $(".results tbody[name='first'] tr:containsi('" + searchSplit + "')").each(function(e){
    $(this).attr('visible','true');
  });

  if($('.results tbody[name="first"] tr[visible="true"]').length == '0') {$('.no-result').show();}
    else {$('.no-result').hide(); $('.no-result').attr('visible','false');}
      
  var jobCount = $('.results tbody[name="first"] tr[visible="true"]').length;
    $('#counter1').text(jobCount + ' item');
    
  });
});

$(document).ready(function() {
  $("#search2").keyup(function () {
    var searchTerm = $("#search2").val();
    //var listItem = $('.results tbody').children('tr');
    var searchSplit = searchTerm.replace(/ /g, "'):containsi('")
    
  $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
        return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }
  });
    
  $(".results tbody[name='second'] tr").not(":containsi('" + searchSplit + "')").each(function(e){
    $(this).attr('visible','false');
  });

  $(".results tbody[name='second'] tr:containsi('" + searchSplit + "')").each(function(e){
    $(this).attr('visible','true');
  });

  if($('.results tbody[name="second"] tr[visible="true"]').length == '0') {$('.no-result').show();}
    else {$('.no-result').hide(); $('.no-result').attr('visible','false');}
      
  var jobCount = $('.results tbody[name="second"] tr[visible="true"]').length;
    $('#counter2').text(jobCount + ' item');
    
  });
});