document.getElementById('assessmentCancel').onclick = function() {
   if(confirm("Are you sure? Progress will be lost."))
   {
       location.replace("assessment.html");
   }
};