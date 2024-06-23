export function loadSuggestions() {
    return {
        isLoadingSuggestions: false,
        suggestions: [],
        actualPage: 0,
        totalPages: 0,
        getData() {
            this.isLoadingSuggestions = true;

            const queryString = window.location.search;
            const parameters = new URLSearchParams(queryString);
            const page = parameters.get('page');
            fetch(`/api/suggestions?page=${page}`)
                .then((response) => response.json())
                .then((data) => {
                    this.suggestions = data.suggestions;
                    this.actualPage = data.actualPage;
                    this.totalPages = data.totalPages;
                })
                .catch(err => {
                    console.error('err', err);
                })
                .finally(() => {
                    this.isLoadingSuggestions = false;
                });
        }
    }
}

export function voteForSuggestion() {
    return {
        isVoting: false,
        vote(suggestionId) {
            if (!this.isVoting) {
                this.isVoting = true;
                let responseStatus;
                fetch(`/api/suggestions/vote/${suggestionId}`, {
                    method: 'PUT'
                })
                    .then((response) => {
                        responseStatus = response.status;
                        return response.json();
                    })
                    .then((data) => {
                        if (responseStatus !== 200) {
                            if (data.message) {
                                // TODO: Show error message
                            }
                            return;
                        }

                        // Get the suggestion's list
                        const suggestions = this.suggestions;
                        if (suggestions) {
                            // Update infos from suggestion voted
                            return suggestions.forEach((suggestion) => {
                                if (suggestion.id === suggestionId) {
                                    suggestion.isVoted = true;
                                    suggestion.votes += 1;
                                }
                            });
                        }
                    })
                    .catch(err => {
                        console.error('err', err);
                    })
                    .finally(() => {
                        this.isVoting = false;
                    });
            }
        }
    }
}
