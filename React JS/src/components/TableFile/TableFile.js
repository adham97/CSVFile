import React from 'react';
import './TableFile.css';

function TableFile(props) {
    return (
        <div className="container">
            <div>
                <h1>Table CSV File Uploaded Website</h1>
                <br/>
                <br/>
            </div>
            <div className="div-table">
                <span className="span-name">File Name</span>
                <span className="span-number">Number of lines</span>
                <span className="span-date">Date Upload</span>
                <div calssName="item-div" key={Math.random()}>
                    <span className="name">{props.csvFile.file_name}</span>
                    <span className="number">{props.csvFile.number_of_lines}</span>
                    <span className="date">{props.csvFile.date}</span>
                </div>
            </div>
        </div>
    );
}

export default TableFile;