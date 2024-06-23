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
            const page = parameters.get('page') ?? 1;
            fetch(`/suggestions?page=${page}`)
                .then((response) => response.json())
                .then((data) => {
                    if (!data.suggestions.length && page > 1) {
                        // If suggestions is empty (and page is greater than 1), redirect to home
                        return window.location.href = '/';
                    }
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
                fetch(`/suggestions/vote/${suggestionId}`, {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    method: 'PUT'
                })
                    .then((response) => {
                        responseStatus = response.status;
                        return response.json();
                    })
                    .then((data) => {
                        if (responseStatus !== 200) {
                            if (data.message) {
                                alert(data.message);
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
