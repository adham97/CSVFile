import React, { Component } from 'react';
import UploadFile from './components/UploadFile/UploadFile'; 
import TableFile from './components/TableFile/TableFile';
import './App.css'

class App extends Component{
  state = {
    data: [{id: '', file_name: '', number_of_lines: '', date : ''}]
  }

  constructor(props) {
    super(props)
    this.state = { isEmptyState: true }
  }

  triggerAddTripState = () => {
    this.setState({
      ...this.state,
      isEmptyState: false,
      isAddTripState: true
    })
  }

  setDataFile = (data) => {
    this.setState({data});
    this.triggerAddTripState();
  }

  render() {
    return (
      <div className="App">   
        {this.state.isEmptyState && <UploadFile setDataFile={this.setDataFile} />}
        {this.state.isAddTripState && <TableFile csvFile={this.state.data} />}
      </div>
    );
  }
}

export default App;
