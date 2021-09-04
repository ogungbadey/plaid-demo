import "./styles/Spinner.css"
export default function Spinner({loading}){
    return <div className="loader" style={{
        visibility: loading ? "visible" : "hidden"
    }}></div>
}