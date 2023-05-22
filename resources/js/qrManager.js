function getQR() {
    var amount = document.getElementById("amount").value;
    $.ajax({
        url: "{{ route('profile.getQR') }}",
        type: "POST",
        data: { amount: amount },
        success: function(response) {
            $('#confirmarModal').modal('hide');
            $('#qrModal .modal-body').html('<img src="' + response.qr_image + '">');
            $('#qrModal').modal('show');
        },
        error: function(xhr) {
            alert('Error: ' + xhr.responseText);
        }
    });
}