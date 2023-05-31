<?php
$title = "Login";
$style = "./index.css";
$script = '<script src="https://accounts.google.com/gsi/client" async defer></script>';
$favicon = "../../assets/favicon.ico";
include_once("../../components/head.php");
require_once("../../Google Login/config.php");
?>

<script>
    function handleCredentialResponse(response) {
        console.log("Encoded JWT ID token: " + response.credential);
    }
    window.onload = function () {
        google.accounts.id.initialize({
            client_id: "YOUR_GOOGLE_CLIENT_ID",
            callback: handleCredentialResponse
        });
        google.accounts.id.renderButton(
            document.getElementById("buttonDiv"),
            { theme: "outline", size: "large" }
        );
        google.accounts.id.prompt();
    }
</script>

<body>
    <div class="outerGrid">
        <div class="Main">
            <div class="first">
                <img src="../../assets/logo.jpeg" class="logo" alt="...">
            </div>
            <div class="second">
                <div class="imageContainer">
                    <img src="../../assets/College.png" class="image1" alt="...">
                    <img src="../../assets/Google.png" class="image2" alt="...">
                </div>
                <div class="signInText">
                    <p class="pceTitle">PCE Internship Portal</p>
                    <p class="mailDesc">
                        Sign in with Student MES Account Only
                    </p>
                </div>
                <div class="signIn">
                    <?php echo "<a href='" . $client->createAuthUrl() . "'>Sign In</a>";  ?>
                </div>
            </div>
        </div>


    </div>
    <!-- <div class="">

        


        

    </div> -->

</body>

</html>