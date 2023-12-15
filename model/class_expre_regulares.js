class Exp_regulares{
	email(email){
		 // Define our regular expression.
         var validEmail =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;

         // Using test we can check if the text match the pattern
         if(validEmail.test(email)){
             // alert('Email is valid, continue with form submission');
                    return true;
         }else{
             // alert('Email is invalid, skip form submission');
             return false;
         }
	}
}
let expresiones_re = new Exp_regulares();