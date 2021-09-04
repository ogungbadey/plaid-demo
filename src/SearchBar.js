import React, { useEffect, useState } from "react";
import { FaSearch } from "react-icons/fa";
import "./styles/SearchBar.css";
const SearchBar = ({changeInput, filterBanks, banks, userInput, filteredBanks}) => {
    
    //console.log(filteredBanks)
    useEffect(() => {
        // console.log("effect fired")
        if(userInput.length < 1) {
            return 
        }
        filterBanks()
    }, [userInput])
    return <div className="SearchBar">
        <i className="magnifyingGlass"><FaSearch/></i>
        
        <input className="SearchBarInput SearchBarInputUnselected" onChange={(e) => {
              changeInput(e.target.value)
            }} type="text" placeholder="Search" 
        />
    </div>
}

export default React.memo(SearchBar);