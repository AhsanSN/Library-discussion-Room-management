<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<?include("./phpParts/head.php")?>
<?include("./phpParts/footer.php")?>
<html>
<head>
  <body></body>  
    </html>
</head>
<script>
    Swal.fire({
      title: 'dajksdjsa',
      html: 
          "<pre style='background-color:#f0e7f3; white-space:pre-wrap;'><code>qwewqe</code></pre>"
          +"<pre style='background-color:#f0e7f3; white-space:pre-wrap;'><code>qweqwewqe</code></pre>",
      showConfirmButton: true,
      confirmButtonText:    'Send Whatsapp!',
    }).then(function() {
// Redirect the user
window.open(
  "https://wa.me/923362286024?text=hello my name is ahsan",
 //https://web.whatsapp.com/send?phone=923332256816&text=hello%20my%20name%20is%20ahsan
  '_blank' // <- This is what makes it open in a new window.
);
console.log('The Ok Button was clicked.');
});
</script>