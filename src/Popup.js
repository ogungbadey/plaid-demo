import { useState } from "react";
import { BiArrowBack, BiCheck } from "react-icons/bi";
import { GrClose } from "react-icons/gr";
import BankLogin from "./BankLogin";
import Intro from "./Intro";
import NavBar from "./NavBar";
import SelectBank from "./SelectBank";
import "./styles/Popup.css";
export default function Popup({ closeBackDrop }) {


const imgUrl = `${process.env.PUBLIC_URL}/assets/images/chase.png`;

const [counter, setCounter] = useState(0);
const [selectedBank, setSelectedBank] = useState({})
const popular = false
const banks = [{
    name: "Chase Bank",
    logo: imgUrl,
    url: "www.chase.com",
    popular: true
},{
    name: "Wells Fargo",
    logo: `${process.env.PUBLIC_URL}/assets/images/wellsfargo.png`,
    url: "www.wellsfargo.com",
    popular: true
},{
    name: "Bank of America",
    logo: `${process.env.PUBLIC_URL}/assets/images/bankofamerica.png`,
    url: "www.bankofamerica.com",
    popular: true
}, {
    name: "Chime",
    logo: `${process.env.PUBLIC_URL}/assets/images/chime.png`,
    url: "www.chime.com",
    popular: true
}, {
    name: "Navy Federal Credit Union",
    logo: `${process.env.PUBLIC_URL}/assets/images/navyfederalcreditunion.png`,
    url: "www.navyfederal.org",
    popular: true
}, {
    name: "Capital One",
    logo: `${process.env.PUBLIC_URL}/assets/images/capitalone.png`,
    url: "www.capitalone.com",
    popular: true
},{
    name: "Citibank",
    logo: `${process.env.PUBLIC_URL}/assets/images/citibank.png`,
    url: "www.citi.com",
    popular: true
},{
    name: "Varo Bank",
    logo: `${process.env.PUBLIC_URL}/assets/images/varo.png`,
    url: "www.varomoney.com",
    popular: true
},{
    name: "USAA",
    logo: `${process.env.PUBLIC_URL}/assets/images/usaa.png`,
    url: "www.usaa.com",
    popular: true
},{
    name: "Schools First FCU",
    logo: `${process.env.PUBLIC_URL}/assets/images/institution.png`,
    url: "www.schoolsfirstfcu.org",
    popular: true
},{
    name: "Sutton Bank",
    logo: `${process.env.PUBLIC_URL}/assets/images/suttonbank.png`,
    url: "www.suttonbank.com",
    popular: true
},{
    name: "Golden 1 Credit Union",
    logo: `${process.env.PUBLIC_URL}/assets/images/golden1creditunion.png`,
    url: "www.golden1.com",
    popular: true
},{
    name: "Dave Bank",
    logo: `${process.env.PUBLIC_URL}/assets/images/dave.png`,
    url: "www.dave.com",
    popular: true
},{
    name: "Union Bank",
    logo: `${process.env.PUBLIC_URL}/assets/images/unionbank.png`,
    url: "www.unionbank.com",
    popular: true
},{
    name: "PNC",
    logo: `${process.env.PUBLIC_URL}/assets/images/institution.png`,
    url: "www.pnc.com",
    popular: true
},{
    name: "TD Bank",
    logo: `${process.env.PUBLIC_URL}/assets/images/institution.png`,
    url: "www.tdbank.com",
    popular: true
},{
    name: "Suntrust",
    logo: `${process.env.PUBLIC_URL}/assets/images/suntrust.png`,
    url: "www.suntrust.com",
    popular: true
},{
    name: "Regions Bank",
    logo: `${process.env.PUBLIC_URL}/assets/images/regionsbank.png`,
    url: "www.regions.com",
    popular: true
},{
    name: "gugurd bank",
    logo: `${process.env.PUBLIC_URL}/assets/images/citibank.png`,
    url: "www.chasebank.com"
},{
    name: "gugurd bank",
    logo: `${process.env.PUBLIC_URL}/assets/images/citibank.png`,
    url: "www.chasebank.com"
},{
    name: "gugurd bank",
    logo: `${process.env.PUBLIC_URL}/assets/images/citibank.png`,
    url: "www.chasebank.com",
},{
    name: "gugurd bank",
    logo: `${process.env.PUBLIC_URL}/assets/images/citibank.png`,
    url: "www.chasebank.com",
}];

//console.log(banks)
const nextPage = (index = undefined) => {
    if(index >= 0){
      //console.log(index)
      setSelectedBank(Object.assign(selectedBank,banks[index])) 
    }
    if (counter >= 2) return;
    setCounter(counter + 1);
  };

  const prevPage = () => {
    if (counter <= 0) return;
    setCounter(counter - 1);
  };

  const pages = [
    <Intro btnClick={nextPage} />,
    <SelectBank banks={banks} nextPage={nextPage}/>,
    <BankLogin bank={selectedBank}/>
  ];

  return (
    <main className="Popup">
      <NavBar counter={counter} closeBackDrop={closeBackDrop} prevPage={prevPage} />
      <div className="PopContent">{pages[counter]}</div>
    </main>
  );
  
}
