/**
 * Function to populate the form when errors were caught on validation 
 */
populateForm = function(formData) {
	if (formData['isValid'] == false) {
		for (i in formData.original) {
			$("#"+i).val(formData.original[i]);
			for (error in formData.errors[i]) {
				if (formData.errors[i][error]) {
    				$("#field"+i+ " ul").append("<li>"+formData.errors[i][error]+"</li>");
    				$("#field"+i).show();
				}
				
			}
		}
	}
}