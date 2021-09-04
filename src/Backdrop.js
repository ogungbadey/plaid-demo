import Popup from "./Popup";
import "./styles/Backdrop.css";
export default function Backdrop({ isVisible, closeBackDrop }) {
  return (
    <div
      className="Backdrop"
      style={{
        visibility: isVisible ? "visible" : "hidden"
      }}
    >
      <div className="BackdropContent">
        <div className="BackdropBG"></div>
        <Popup closeBackDrop={closeBackDrop} />
      </div>
    </div>
  );
}
