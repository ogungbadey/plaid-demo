export default function Pages() {
  return (
    <>
      <div>
        <div>
          <img
            style={{
              height: "100%",
              width: "100%",
              objectFit: "contain"
            }}
            alt="logo"
            src="https://cdn.plaid.com/link/2.0.1120/assets/images/ppip@3x.png"
          />
        </div>
        <h1
          style={{
            margin: "0",
            fontWeight: "300",
            letterSpacing: "-0.3px"
          }}
        >
          Our organization uses Plaid to verify your bank account{" "}
        </h1>
        <div
          style={{
            marginTop: "10px"
          }}
        >
          <ul
            style={{
              padding: "0",
              margin: "0",
              listStyle: "none"
            }}
          >
            <li
              style={{
                display: "flex"
              }}
            >
              <BiCheck />
              <div>
                <h2
                  style={{
                    margin: "0"
                  }}
                >
                  Secure
                </h2>
                <p
                  style={{
                    margin: "0"
                  }}
                >
                  Encryption helps protect your personal financial data
                </p>
              </div>
            </li>
            <li
              style={{
                display: "flex"
              }}
            >
              <BiCheck />
              <div>
                <h2
                  style={{
                    margin: "0"
                  }}
                >
                  Secure
                </h2>
                <p
                  style={{
                    margin: "0"
                  }}
                >
                  Your credentials will never be made accessible to Classy Pay
                </p>
              </div>
            </li>
          </ul>
        </div>
      </div>
      <div>
        <button>
          <p class="FinePrint FinePrint--is-threads-treatment">
            By selecting “Continue” you agree to the{" "}
            <u>Plaid End User Privacy Policy</u>
          </p>
        </button>
        <button>
          <span class="Button-module_flex__2To5J">Continue</span>
        </button>
      </div>
    </>
  );
}
