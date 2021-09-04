import "./styles/BankList.css";
export default function BankList({banks, userInput, nextPage, filteredBanks}){
    const imgUrl = `${process.env.PUBLIC_URL}/assets/images/chase.png`;
    const imgUrl2 = `${process.env.PUBLIC_URL}/assets/images/wellsfargo.png`;
    const renderList = list => {
        return list.reduce((a,b,i) => b.popular ? [...a, b]: a ,[]).map((item, i) => {
            return <li key={i} onClick={() => {
                // console.log(i)
                nextPage(i)  //Next page is called when a list item is clicked
            }}>
                <button className="ThreadsInstitutionResult_button">
                    <div style={{
                        display:"flex"
                        }}
                        className="ThreadsInstitutionResult">
                    
                        <div style={{
                            backgroundImage: `url(${item.logo})`
                            }}
                            className="Logo">
                        </div>

                        <div className="ThreadsInstitutionResult_text">
                            <p className="ThreadsInstitutionResult_name">{item.name}</p>
                            <p className="ThreadsInstitutionResult_url">{item.url}</p>
                        </div>

                    </div>
                </button>
            </li> 
        })
    }
    
    return  <div className="BankList">
        <ul>
                {userInput.length > 0 ? renderList(filteredBanks): renderList(banks)} 

            {/*Last Item in List*/}
            <li>
                <button className="TextButton lastItemInList">
                    <p class="FinePrint TextButton">Why is Plaid involved?</p>
                </button>
                <br></br><br></br>
                <div>
                    <button className="TextButton LastButton lastItemInList"><p>Don’t see your bank? Search instead</p></button>
                </div>
            </li>

        </ul>

    </div>

}