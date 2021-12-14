import React, {Component} from 'react';
import ReactDOM from 'react-dom';

class Example extends Component {
    constructor(props) {
        super(props);
        this.state = {
            news: null,
            clicked: null
        };
    }

    markAsRead(id) {
        this.setState({clicked: id});
        fetch('/dashboard/state/' + id + '/mark-as-read')
            .then(response => console.log(response));
    }

    timeDifference(previous) {
        const current = new Date();
        const msPerMinute = 60 * 1000;
        const msPerHour = msPerMinute * 60;
        const msPerDay = msPerHour * 24;
        const msPerMonth = msPerDay * 30;
        const msPerYear = msPerDay * 365;

        const elapsed = current - previous;

        if (elapsed < msPerMinute) {
            return 'Just now'
        } else if (elapsed < msPerHour) {
            const minutesAgo = Math.round(elapsed / msPerMinute);
            if (minutesAgo === 1) {
                return '1 minute ago';
            }
            return minutesAgo + ' minutes ago';
        } else if (elapsed < msPerDay) {
            const hoursAgo = Math.round(elapsed / msPerHour);
            if (hoursAgo === 1) {
                return 'An hour ago';
            }
            return hoursAgo + ' hours ago';
        } else if (elapsed < msPerMonth) {
            const daysAgo = Math.round(elapsed / msPerDay);
            if (daysAgo === 1) {
                return 'Yesterday';
            }
            return Math.round(elapsed / msPerDay) + ' days ago';
        } else if (elapsed < msPerYear) {
            const monthsAgo = Math.round(elapsed / msPerMonth);
            if (monthsAgo === 1) {
                return 'Last month';
            }
            return monthsAgo + ' months ago';
        } else {
            return Math.round(elapsed / msPerYear) + ' years ago';
        }
    }

    componentDidMount() {

        this.loadNewsData();

        Echo.channel('lyfee')
            .listen('NewsWasUpdatedEvent', (e) => {
                console.log(e.news);
                this.setState({
                    news: e.news
                });
            });
    }

    loadNewsData() {
        fetch('/dashboard/state')
            .then();
    }

    render() {

        if (this.state.news === null) {
            return <div/>;
        }

        const items = this.state.news.map(item => {
            return (
                <div className={`flex flex-col pb-2 ${item.id === this.state.clicked ? "opacity-50" : ""}`} key={item.id}>
                    <div
                        className="shadow drop-shadow-md relative flex flex-col items-start p-4 pt-2 m-0 bg-white rounded-lg bg-opacity-90 group hover:bg-opacity-100"
                        draggable="true">
                        <div>
                            <a href={item.url} target="_blank" rel="noreferrer"
                               onClick={this.markAsRead.bind(this, item.id)}>
                                <h4 className="mt-3 pt-0 mt-0 text-sm font-medium">{item.title}</h4>
                            </a>
                        </div>
                        <div className="flex items-center w-full mt-3 text-xs font-medium text-gray-400">
                            <div className="flex items-center w-full">
                                <svg className="w-4 h-4 text-gray-300 fill-current"
                                     xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fillRule="evenodd"
                                          d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                          clipRule="evenodd"/>
                                </svg>

                                <span
                                    className="clearfix ml-1 leading-none w-11/12">{this.timeDifference(new Date(item.date * 1000))}</span>
                                <span
                                    className="w-1/12 text-red-500 cursor-pointer" onClick={this.markAsRead.bind(this, item.id)}>X</span>
                            </div>
                        </div>
                    </div>
                </div>
            );
        });

        return (
            <div className="flex flex-col w-72 my-4 ml-4 bg-blue-50 p-4 rounded-b-md rounded-t-md">
                <div className="flex h-10 px-2">
                    <span className="block text-sm font-semibold">BBC News</span>
                    <span
                        className="flex items-center justify-center p-2 h-5 ml-2 text-sm font-semibold text-black bg-blue-300 rounded bg-opacity-30">
                        {this.state.news.length}
                    </span>
                </div>

                <div>{items}</div>
            </div>
        );
    }
}

export default Example;

if (document.getElementById('example')) {
    ReactDOM.render(<Example/>, document.getElementById('example'));
}
