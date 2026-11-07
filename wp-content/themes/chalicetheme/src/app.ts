// --- Necessary web awesome component imports ---


// -----------------------------------------------

///<reference types="vite/client" />

import './styles/main.css'
import { LitElement, html, css } from 'lit';

export class ChaliceApp extends LitElement {
  static styles = css`

  `

  render() {
    return html`
        <header>
          <p>Chalice</p>  
        </header>
    
    `;
  }
}

customElements.define('chalice-app', ChaliceApp);