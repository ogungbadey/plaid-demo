import { BiArrowBack } from "react-icons/bi";
import { GrClose } from "react-icons/gr";
import "./styles/NavBar.css";

export default function NavBar({ counter, closeBackDrop, prevPage }) {

  const plaidImgUrl = `${process.env.PUBLIC_URL}/assets/images/plaidlogo.png`;

  return (
    <>
      <nav className="NavBar">

        <button className="LeftBtn" onClick={() => prevPage()}>
          <span>
            {counter > 0 ? <BiArrowBack /> : null}
          </span>
        </button>

        {counter > 0 ? <div style={{
          backgroundImage: `url(${plaidImgUrl})`
          }}
          className="PlaidLogoParent">
        </div> : null}

        <button  className="RightBtn" 
          onClick={() => {
            closeBackDrop();
          }}
        >
          <span>
            <GrClose />
          </span>
        </button>

      </nav>
    </>
  );
}
