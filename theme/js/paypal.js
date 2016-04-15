(function ($){
	var $donationForm;

	$("form").each(function (d) {
		if (this.action.indexOf("paypal") > -1) {
			$donationForm = $(this);
		}
	});

	var $donateLink = $("#donate-button");

	if(!$donationForm) {
		$donateLink.remove();		
	}

	$donateLink.find("a").click(function (e) {
		e.preventDefault();
		$donationForm.submit();
	});
})(jQuery)