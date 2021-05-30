import React, { Component } from 'react';
import './UploadFile.css';

class UploadFile extends Component {
    constructor(props) {
        super(props);
        this.handleSubmit  = this.handleSubmit.bind(this);
        this.csvFile = React.createRef();
      }

      handleSubmit = async (e) => {
        e.preventDefault();
        const formData = new FormData();
        formData.append("file", this.csvFile.current.files[0]);
        await fetch("http://localhost:8000/api/uploadFile", {
            method: "POST",
            body: formData,
        }).then(response => response.json()
        ).then(data => {
            this.props.setDataFile(data[0])
        }).catch(()=>{
            alert('Error in the Code');
        });
    }

    render() {
        return (
            <div className="container">
                <div>
                    <h1 className="titel">Welcome in CSV File Upload Website</h1>
                    <br/>
                    <br/>
                </div>
                <form onSubmit={this.handleSubmit}>
                    <div className="form-div">
                        <input className="select-file-button" type="file" ref={this.csvFile}/>
                    </div>
                    <button className="upload-file-button" type="submit">Upload File</button>
                </form>
            </div>
        );
    }
}

export default UploadFile;