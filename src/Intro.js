import { BiArrowBack, BiCheck } from "react-icons/bi";
import "./styles/Intro.css";

export default function Intro({ btnClick }) {
  return (
    <div className="Container">

      <div className="Content">

        <div className="LogoContainer">
          <img
            alt="logo"
            src="https://cdn.plaid.com/link/2.0.1120/assets/images/ppip@3x.png"
          />
        </div>

        <h1>Our organization uses Plaid to verify your bank account </h1>

        <div 
          className="IntroChecklistParent" >

          <ul 
            /*style={{
              padding: "0",
              margin: "0",
              listStyle: "none"
            }}*/
            className="IntroChecklist">

            <li className="ChecklistRow">
              <i className="CheckMark"><BiCheck /></i>
              <div>
                <h2 className="CheckListPrimaryText">Secure</h2>
                <p className="CheckListSecondaryText">Encryption helps protect your personal financial data</p>
              </div>
            </li>

            <li className="ChecklistRow">
              <i className="CheckMark"><BiCheck /></i>
              <div>
                <h2 className="CheckListPrimaryText">Private</h2>
                <p className="CheckListSecondaryText">Your credentials will never be made accessible after donating</p>
              </div>
            </li>
            
          </ul>

        </div>

      </div>

      <div className="Action">

        <button className="ButtonInAction"
        >

          <p class="ActionFinePrint">
            By selecting “Continue” you agree to the{" "}
            <u>Plaid End User Privacy Policy</u>
          </p>

        </button>


        <button className="ButtonAfterAction"
          onClick={() => btnClick()}
        >
          <span class="ContinueButton">Continue</span>
        </button>

      </div>

    </div>
  );
}
