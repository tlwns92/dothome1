<div id="wrapper">
  <div id="page">
    <div id="content">
      <div class="signbox">
        <div id="navbox">
          <ul class="nav">
              
            <div class="small-categori">
              <li onclick="showLogin()">Log in</li>
            </div>

            <div class="small-categori">
              <li onclick="showSignup()">Sign up</li>
            </div>


            <div class="small-categori">
              <li onclick="showContactUs()">Contact us</li>
            </div>
          </ul>
        </div>

    <div class="wrapper2">
      <div class="rec-prism">
    
        <div class="face face-left">
          <div class="content2 signup-content">
            <h2>Log in</h2>
            <form onsubmit="event.preventDefault()">
              <div class="field-wrapper">
                <input type="text" name="login-email" id="login-email" placeholder="email" />
                <label>email</label>
              </div>
              <div class="field-wrapper">
                <input
                  type="password"
                  name="login-password"
                  id="login-password"
                  placeholder="password"
                  autocomplete="new-password"
                />
                <label>password</label>
              </div>
              <div class="field-wrapper">
                <input type="submit" value="Log in" onclick="logincheck()"/>
              </div>
              <span class="psw" onclick="showForgotPassword()">Forgot Password?</span>
              <span class="signup" onclick="showSignup()">Not a user? Sign up</span>
            </form>
          </div>
        </div>




        <div class="face face-back">
          <div class="content2">
            <h2>Forgot your password?</h2>
            <small>Enter your email so we can send you a reset link for your password</small>
            <form onsubmit="event.preventDefault()">
              <div class="field-wrapper">
                <input type="text" name="email" placeholder="email" />
                <label>e-mail</label>
              </div>
              <div class="field-wrapper">
                <input type="submit" onclick="showThankYou()" />
              </div>
            </form>
          </div>
        </div>


        


        <div class="face face-front">
          <div class="content2 signup-position">
            <h2>Sign up</h2>
            <form onsubmit="event.preventDefault()">
              <div class="field-wrapper">
                <input type="text" id="email" name="email" class="check" placeholder="email" />
                <label>e-mail</label>
              </div>
              <div class="field-wrapper">
                <input type="password"  id="password" name="password" class="check" placeholder="password" autocomplete="new-password"/>
                <label>password</label>
              </div>
              <div class="field-wrapper">
                <input type="password" id="confirmpassword" name="confirmpassword" class="check" placeholder="password" autocomplete="new-password"/>
                <label>confirm password</label>
              </div>
              <br>
              <div id="check_string">입력란을 채워주세요.</div>
              <div class="field-wrapper">
                <input type="hidden" id="check_sub_button" name="check_sub_button" value="2"/>
                <input type="submit" id="submit-btn" name="submit" class="sign-submit" onclick="sign_showThankYou()" disabled/>
              </div>
              <span class="singin" onclick="showLogin()">Already a user? Sign in</span>
            </form>
          </div>
        </div>



        <div class="face face-right">
          <div class="content2">
            <h2>Contact us</h2>
            <form onsubmit="event.preventDefault()">
              <div class="field-wrapper">
                <input type="text" name="name" placeholder="name" />
                <label>Name</label>
              </div>
              <div class="field-wrapper">
                <input type="text" name="email" placeholder="email" />
                <label>e-mail</label>
              </div>
              <div class="field-wrapper">
                <textarea placeholder="your message"></textarea>
                <label>your message</label>
              </div>
              <div class="field-wrapper">
                <input type="submit" onclick="showThankYou()" />
              </div>
            </form>
          </div>
        </div>
       

       

        <div class="face face-bottom">
          <div class="content2">
            <div class="thank-you-msg">Welcome!</div>
            <div class="go-log-in"><button id="go-log-in" onclick="showLogin()">go log in</button></div>
            
          </div>
        </div>
</div>
    </div>
</div>
</div>
