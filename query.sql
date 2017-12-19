select 
    game.gameid, 
    game.city as gamecity,
    gamedate,
    headofficialid,
    team.city as team1city, 
    team.teamname as team1, 
    team1score,
    team2score,
    team2.teamname as team2,
    team2.city as team2city

from team, team as team2, game
where
    game.gameid = 10
    and
    team1id = team.teamid 
    and 
    team2id = team2.teamid
;

select gameid, firstname, lastname 
from officiates, official
where 
    official.officialid = officiates.officialid 
    and 
    gameid = 10;

-- All leaf game info
SELECT
    team.teamname AS team1, team.city AS team1city, team1score,
    team2.teamname AS team2, team2.city AS team2city, team2score
FROM game, team, team AS team2
WHERE
    team1id = team.teamid 
    AND (
        team1id in (SELECT teamid FROM team WHERE teamname = 'Maple Leafs')
        OR 
        team2id in (SELECT teamid FROM team WHERE teamname = 'Maple Leafs')
    )
    AND team2id = team2.teamid
;

-- officiated leafs GAMES, sorted by # games
SELECT count(official.officialid) c, firstname, lastname
FROM game, team, team AS team2, official, officiates
WHERE
    team1id = team.teamid 
    AND (
        team1id in (SELECT teamid FROM team WHERE teamname = 'Maple Leafs')
        OR 
        team2id in (SELECT teamid FROM team WHERE teamname = 'Maple Leafs')
    )
    AND team2id = team2.teamid
    AND game.gameid = officiates.gameid
    AND official.officialid = officiates.officialid
    group by official.officialid
    order by c desc
;


-- leafs WINS
SELECT count(official.officialid) c, firstname, lastname
FROM game, team, team AS team2, official, officiates
WHERE
    team1id = team.teamid 
    AND (
            (team1id in (SELECT teamid FROM team WHERE teamname = 'Maple Leafs')
                AND team1score > team2score
            )
        OR 
            (team2id in (SELECT teamid FROM team WHERE teamname = 'Maple Leafs')
                AND team2score > team1score
            )
    )
    AND team2id = team2.teamid
    AND game.gameid = officiates.gameid
    AND official.officialid = officiates.officialid
    group by official.officialid
    order by c desc
;

-- For losses, just replace '>' with '<'
