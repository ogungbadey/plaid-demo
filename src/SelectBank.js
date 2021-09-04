import { useState } from "react";
import { BiSearch } from "react-icons/bi";
import BankList from "./BankList";
import SearchBar from "./SearchBar";
import "./styles/SelectBank.css";

export default function SelectBank({banks, nextPage}) {
  const [userInput, setUserInput] = useState("");
  const [filteredBanks, setFilteredBanks] = useState([]);

  const filterBanks = () => {
    setFilteredBanks(banks.filter(bank => {
      return bank.name.toLowerCase().includes(userInput.toLowerCase())
  }))
  }

  const changeInput = (input) => {
    setUserInput(input)
  }
  return (
    <div className="Container">
      <h1 className="SelectBankMargins">Select your bank</h1>
      <SearchBar changeInput={changeInput} filterBanks={filterBanks} filteredBanks={filteredBanks} userInput={userInput} banks={banks}/>
      <div className="BankParent">
        <BankList input={userInput} banks={banks} userInput={userInput} filteredBanks={filteredBanks} nextPage={nextPage}/>
      </div>
      
    </div>
  );
}
