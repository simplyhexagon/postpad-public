//Password strength evaluation
$(function() {
    $('#newpass').on('keypress', function(){
        //We are delaying the read so the character actually has time to register
        setTimeout(function(){
            var password = document.getElementById("newpass").value;
            

            //How many points does the password achieve
            var points = 0;
            var capsPoints = 0;
            var numPoints = 0;
            var charPoints = 0;

            //If the password is less than 10 characters, it gets the points of charcount/2
            if(password.length <= 10){
                points = password.length / 2;
            }
            else if(password.length > 10){
                points = 5;
            }

            //If the password contains a capital letter, add a point
            const capitals = /[A-Z]/g;
            var passCaps = password.match(capitals);
            if(passCaps != null){
                if(passCaps.length <=3){
                    capsPoints = passCaps.length;
                }
                else{
                    capsPoints = 3;
                }
            }
            //If the password contains a number, add a point
            const numberz = /[0-9]/g;
            var passNums = password.match(numberz);
            if(passNums != null){
                if(passNums.length  <=3){
                    numPoints = passNums.length;
                }
                else{
                    numPoints = 3;
                }
            }
            //If the character contains a special character, add 2 points
            const charz = /[^0-9A-Za-z\s]/g;
            var passChars = password.match(numberz);
            if(passChars != null){
                if(passChars.length  < 3){
                    charPoints = 2 * passChars.length;
                }
                else{
                    charPoints = 4;
                }
            }

            //Summarise the points
            points += capsPoints + numPoints + charPoints;

            
            if(points <= 5){
                document.getElementById("passwordstrength").innerHTML = "Weak";
            }
            else if(points >= 6 && points <= 9){
                document.getElementById("passwordstrength").innerHTML = "Strong";
            }
            else if(points >= 10){
                document.getElementById("passwordstrength").innerHTML = "Very strong!";
            }

            
            //Checking for whitespace and overwriting
            var passWhiteSpace = password.match(/[\s]/g);
            if(passWhiteSpace != null && passWhiteSpace.length > 0){
                document.getElementById("passwordstrength").innerHTML = "Password cannot contain spaces!";
            }
        }, 125);
    })
});

//Password strength evaluation END