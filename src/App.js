import { useEffect, useState } from "react";
import Backdrop from "./Backdrop";
import Spinner from "./Spinner";
import "./styles.css";

export default function App() {
  const [loadTime, setLoadTime] = useState(0)
  const [loading, setLoading] = useState(false)
  
  useEffect(() => {
    const randomTimeGenerator = () => {
      const times = [300, 500, 750, 850, 1000, 625, 1250, 250, 1500, 2000]
      return times[Math.floor(Math.random() * times.length)]
    }
    const mimicRequest = () => {
      setLoadTime(randomTimeGenerator())     
    } 
    
    mimicRequest()
  }, [loading])
  
  const [backdrop, setBackdrop] = useState(false);
  const closeBackDrop = () => {
    setBackdrop(false);
  };
  //console.log(loadTime, loading)

  
  return (
    <div className="App">
      <Backdrop isVisible={backdrop && !loading} closeBackDrop={closeBackDrop} loading={loading}/>
      <Spinner loading={loading}/>
      <button
        onClick={() => {
          setLoading(true)
          setTimeout(() => {
            setLoading(false)
            setBackdrop(true)
          }, loadTime)
        }}
      >
        Bank Transfers
      </button>

    </div>
  );
}
